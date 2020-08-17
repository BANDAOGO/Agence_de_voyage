<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'agence' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Vw=!2`+nADID2?IySj?%(](~:dc]q3MxU(}XR!c~8a,23-P{@DCKSO>)OZV15A C' );
define( 'SECURE_AUTH_KEY',  'H3z8JG:1#d>Tb6K1o&#!,<{RXrW-Hy)l%8EZe*<5jR{b/G+>Lm|MZXSZ?alWo$5!' );
define( 'LOGGED_IN_KEY',    ',>KXYBZ.G.|$&16Iwt~r.uB*qzWDk;G#>6Hwn<ml8N8D ,epD~DhoJRpp~gL?iBg' );
define( 'NONCE_KEY',        'V^nur_VcSSnN)Ttv(O_?_Rh/Mj/|!2nI[D&Qe5*56jjv4`;j}E`TXjw/~Zy&*$BF' );
define( 'AUTH_SALT',        'y-dGR$:ktU+`+%)x6v4ha[QwFB_t&)NAL|919}z@5@l6KD9GU[Xn~aOM5O$5=1Lw' );
define( 'SECURE_AUTH_SALT', '<2QkuAKA)b ix02E&;)YA;x|I{t?(<$M4Z>?MPHE+1<%t+r?Q+&MA*idZaxd;aKH' );
define( 'LOGGED_IN_SALT',   '+w0Ti?WA#kH4O/()fe=raYHxziExw:RPzV$2U&gWwcu;b/L#Z.oJ`Pl|73m>_X`@' );
define( 'NONCE_SALT',       '_XCtIp<6#<et8!y*jypNhz]~C>DTC3MKnt0dpNn,~=Yozyx0?c29(ox+1UfT0*K:' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
