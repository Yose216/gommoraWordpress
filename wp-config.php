<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'ebullition');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'password');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N'y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');
define('FS_METHOD', 'direct');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'e}SPi:viYp&CUgxWG09aAGeiyd^L$W9g/o>t8LKp+_rCwaad>$OB2v8es/_~?d)Z');
define('SECURE_AUTH_KEY',  'WK0m?M-P=iKBbz`!_6FL(+[f6(t5(I35k*fOhx+.sFsJZN]fRWFyq:3DQRF^Uz=n');
define('LOGGED_IN_KEY',    '5Tz,CHoklUEwigE*G]=qe+EVmMQThJ[=E|pI<@gDg{00~;+%&$xs>)fy.76Kq+b9');
define('NONCE_KEY',        'tEEyNs%;l~EmzTZ%^hz(]lY*QW3GyDXlp=c&i-&y$KG/$1ZMpt4pq42 %VI$7(nN');
define('AUTH_SALT',        'M7$8PK#n]Am.<ZmjGyaiVsa#c9nU[$Ldj)V?5/C+nt_3RLUbM:1B[:)&>G%=3+6p');
define('SECURE_AUTH_SALT', '&d!Yp#eoK)y|A7E:h_VdM45`t;)tEEBy-l|ip(&m}G[GMA^i+yt|jp-:@x1BQ3k<');
define('LOGGED_IN_SALT',   'Y],z%]Ep>Itre4O0]YHLbXc7~=*2qu]oM,whXGaem[F`+*e21t7*a0Jd&~hVq={u');
define('NONCE_SALT',       'j65&r}0%v[d|2QP@7rNI(yoWM90)p_K.ckN>QTVL,KMLD8;4b|/1tD!O:a`SPnYe');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_ebu';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d'information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 * 
 * @link https://codex.wordpress.org/Debugging_in_WordPress 
 */
define('WP_DEBUG', false);

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
