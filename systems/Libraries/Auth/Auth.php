<?php
/*///////////////////////////////////////////////////////////////
 /** ID: | /-- ID: Indonesia
 /** EN: | /-- EN: English
 ///////////////////////////////////////////////////////////////*/

/**
 * ID: Cookie - Library untuk framework kecik, library ini khusus untuk membantu masalah Cookie
 * EN: Cookie - Library for Divalia Framework, this library specially for help Cookie problem
 *
 * @author        Dony Wahyu Isp
 * @copyright    2015 Dony Wahyu Isp
 * @link        http://github.com/kecik-framework/cookie
 * @license        MIT
 * @version    1.0.1-alpha
 * @package        Divalia\Cookie
 **/
namespace Divalia;

/**
 * Cookie
 * @package    Divalia\Cokie
 * @author        Dony Wahyu Isp
 * @since        1.0.0-alpha
 **/
class Auth
{
    private static $app;
    private static $mode = 'database';
    private static $ldapHost = '';
    private static $ldapDomain = '';
    private static $ldapBaseDN = '';
    private static $ldapGroup = '';
    private static $activeDirectory;
    
    private static $modelUser;
    private static $postUsername = '';
    private static $postPassword = '';
    private static $fieldUsername = '';
    private static $fieldPassword = '';
    private static $fieldLevel = '';
    private static $info = array();

    private static $loginRoute = 'login';
    private static $logoutRoute = 'logout';
    private static $loginTemplate = 'login';

    private static $encryptFunction = NULL;


    /**
     *
     */
    public static function init()
    {

        self::$app = Divalia::getInstance();;

        self::$mode = (self::$app->config->get('auth.mode') != '') ? strtolower(trim(self::$app->config->get('auth.mode'))) : self::$mode;
        self::$ldapHost = (self::$app->config->get('auth.ldap_host') != '') ? strtolower(trim(self::$app->config->get('auth.ldap_host'))) : self::$ldapHost;
        self::$ldapDomain = (self::$app->config->get('auth.ldap_domain') != '') ? strtolower(trim(self::$app->config->get('auth.ldap_domain'))) : self::$ldapDomain;
        self::$ldapBaseDN = (self::$app->config->get('auth.ldap_basedn') != '') ? strtolower(trim(self::$app->config->get('auth.ldap_basedn'))) : self::$ldapBaseDN;
        self::$ldapGroup = (self::$app->config->get('auth.ldap_group') != '') ? strtolower(trim(self::$app->config->get('auth.ldap_group'))) : self::$ldapGroup;

        self::$modelUser = '\\Models\\' . self::$app->config->get('auth.model');
        self::$postUsername = self::$app->config->get('auth.post_username');
        self::$postPassword = self::$app->config->get('auth.post_password');

        self::$fieldUsername = self::$app->config->get('auth.field_username');
        self::$fieldPassword = self::$app->config->get('auth.field_password');
        self::$fieldLevel = self::$app->config->get('auth.field_level');
        self::$loginRoute = (self::$app->config->get('auth.login_route') != '') ? self::$app->config->get('auth.login_route') : self::$loginRoute;
        self::$logoutRoute = (self::$app->config->get('auth.logout_route') != '') ? self::$app->config->get('auth.logout_route') : self::$logoutRoute;
        self::$loginTemplate = (self::$app->config->get('auth.login_template') != '') ? self::$app->config->get('auth.login_template') : self::$loginTemplate;
        self::$encryptFunction = (self::$app->config->get('auth.encrypt_function') != '') ? self::$app->config->get('auth.encrypt_function') : self::$encryptFunction;

        $username = self::username();

        if (!empty($username)) {

            if (self::$mode == 'database') {
                $model = self::$modelUser;
                $users = $model::find(array(
                    'where' => array(
                        array(self::$fieldUsername, '=', self::username())
                    )
                ));

                if (count($users) > 0) {
                    self::$info = $users[0];
                }
            } elseif (self::$mode == 'ldap') {
                self::$activeDirectory = \ldap_connect('ldap://' . self::$ldapHost);
                \ldap_set_option(self::$activeDirectory, LDAP_OPT_PROTOCOL_VERSION, 3);
                \ldap_set_option(self::$activeDirectory, LDAP_OPT_REFERRALS, 0);
            }

        }

        AuthInit(self::$app);
    }

    /**
     *
     */
    public static function login()
    {
        if (self::$mode == 'database') {
            $model = self::$modelUser;

            if (is_callable(self::$encryptFunction)) {
//                $encryptFunction = self::$encryptFunction;
                $password = self::$encryptFunction($_POST[self::$postPassword]);
            } else {
                $password = md5($_POST[self::$postPassword]);
            }

            $users = $model::find(array(
                'where' => array(
                    array(self::$fieldUsername, '=', $_POST[self::$postUsername]),
                    array(self::$fieldPassword, '=', $password)
                )
            ));

            if (count($users) > 0) {
                $_SESSION[md5('login' . self::$app->url->baseUrl())] = base64_encode('TRUE');
                $_SESSION[md5('username' . self::$app->url->baseUrl())] = base64_encode($_POST[self::$postUsername]);
                $level = self::$fieldLevel;

                foreach ($users as $user) {
                    $_SESSION[md5('level' . self::$app->url->baseUrl())] = base64_encode($user->$level);
                }
            }

        } elseif (self::$mode == 'ldap') {
            self::$activeDirectory = \ldap_connect('ldap://' . self::$ldapHost);
            \ldap_set_option(self::$activeDirectory, LDAP_OPT_PROTOCOL_VERSION, 3);
            \ldap_set_option(self::$activeDirectory, LDAP_OPT_REFERRALS, 0);

            $bind = @\ldap_bind(self::$activeDirectory, $_POST[self::$postUsername] . '@' . self::$ldapDomain, $_POST[self::$postPassword]);
//            $bind = @\ldap_bind(self::$activeDirectory, 'DWIsprananda@telpp.com', 'telpp12345++');

            if ($bind) {
                $userDN = self::getDN();

                //            if (self::checkGroupEx($userDN, self::getDN(self::$ldapGroup, self::$ldapBaseDN))) {
                if (self::checkGroup($userDN, self::getDN(self::$ldapGroup, self::$ldapBaseDN))) {
                    $_SESSION[md5('login' . self::$app->url->baseUrl())] = base64_encode('TRUE');
                    $_SESSION[md5('username' . self::$app->url->baseUrl())] = base64_encode($_POST[self::$postUsername]);

                    $userInfo = explode(',', $userDN);

                    $_SESSION[md5('level' . self::$app->url->baseUrl())] = base64_encode(str_replace('OU=', '', $userInfo[1]));
                    //                echo "You're authorized as ".self::getCN($userDN);
                } /*else {
                    echo 'Authorization failed';
                }*/

                //\ldap_unbind(self::$activeDirectory);
            }


        }

        if (strtolower(substr($_SERVER["HTTP_REFERER"], -(strlen('login')))) === 'login') {
            self::$app->url->redirect('');
        } else {
            header('Location: ' . $_SERVER["HTTP_REFERER"]);
            exit();
        }
    }

    /**
     * @return string
     */
    protected static function getDN()
    {
        $attributes = array('dn');
        $result = \ldap_search(self::$activeDirectory, self::$ldapBaseDN, "(samaccountname={$_POST[self::$postUsername]})", $attributes);

        if ($result === FALSE) {
            return '';
        }

        $entries = \ldap_get_entries(self::$activeDirectory, $result);

        if ($entries['count'] > 0) {
            return $entries[0]['dn'];
        } else {
            return '';
        }

    }

    /**
     * @param $userDN
     * @return mixed
     */
    private static function getCN($userDN)
    {
        preg_match('/[^,]*/', $userDN, $matchs, PREG_OFFSET_CAPTURE, 3);

        return $matchs[0][0];
    }

    /**
     * @param $userDN
     * @param $groupDN
     * @return bool
     */
    private static function checkGroup($userDN, $groupDN)
    {
        $attributes = array('members');

        $result = \ldap_read(self::$activeDirectory, $userDN, "(objectclass=*)", $attributes);

        if ($result == FALSE) {
            return FALSE;
        }

        $entries = \ldap_get_entries(self::$activeDirectory, $result);

        return ($entries['count'] > 0);
    }

    /**
     * @param $userDN
     * @param $groupDN
     * @return bool
     */
    private static function checkGroupEx($userDN, $groupDN)
    {
        $attributes = array('memberof');
        $result = ldap_read(self::$activeDirectory, $userDN, '(objectclass=*)', $attributes);

        if ($result === FALSE) {
            return FALSE;
        }

        $entries = ldap_get_entries(self::$activeDirectory, $result);

        if ($entries['count'] <= 0) {
            return FALSE;
        }

        if (empty($entries[0]['memberof'])) {
            for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
                if ($entries[0]['memberof'][$i] == $groupDN) {
                    return FALSE;
                } elseif (self::checkGroupEx($entries[0]['memberof'][$i], $groupDN)) {
                    return TRUE;
                }
            }
        }

        return FALSE;

    }

    /**
     *
     */
    public static function logout()
    {
        unset($_SESSION[md5('username' . self::$app->url->baseUrl())]);
        unset($_SESSION[md5('level' . self::$app->url->baseUrl())]);
        unset($_SESSION[md5('login' . self::$app->url->baseUrl())]);

        if (self::$mode == 'ldap') {
            self::$activeDirectory = \ldap_connect('ldap://' . self::$ldapHost);
            \ldap_close(self::$activeDirectory);
        }

        self::$app->url->redirect(self::$loginRoute);
    }

    /**
     * @return bool
     */
    public static function isLogin()
    {

        if (isset($_SESSION[md5('login' . self::$app->url->baseUrl())]) &&
            base64_decode($_SESSION[md5('login' . self::$app->url->baseUrl())]) == 'TRUE'
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return string
     */
    public static function username()
    {
        if (isset($_SESSION[md5('username' . self::$app->url->baseUrl())])) {
            return base64_decode($_SESSION[md5('username' . self::$app->url->baseUrl())]);
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public static function level()
    {
        if (isset($_SESSION[md5('level' . self::$app->url->baseUrl())])) {
            return base64_decode($_SESSION[md5('level' . self::$app->url->baseUrl())]);
        } else {
            return '';
        }
    }

    /**
     * @param $field
     * @return string
     */
    public static function info($field)
    {
        if (isset(self::$info->$field)) {
            return self::$info->$field;
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public static function loginRoute()
    {
        return self::$loginRoute;
    }

    /**
     * @return string
     */
    public static function logoutRoute()
    {
        return self::$logoutRoute;
    }

    /**
     * @return string
     */
    public static function loginTemplate()
    {
        return self::$loginTemplate;
    }
}


/**
 * @param $app
 */
function AuthInit($app)
{
    $app->get(Auth::loginRoute(), function () {

        if (Auth::isLogin()) {
            $this->url->redirect('');
        }

    })->template(Auth::loginTemplate());

    $app->post(Auth::loginRoute(), function () {
        Auth::login();
    });

    $app->get(Auth::logoutRoute(), function () {
        Auth::logout();
    });
}