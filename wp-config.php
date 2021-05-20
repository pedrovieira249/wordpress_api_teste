<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'wordpress_teste_api' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=&@|S`7=_%8<}y;KAHvjFAKWRdk?/<1`r8TqC<g?:UU`C%&jtg92S Zo0bz&sW>%' );
define( 'SECURE_AUTH_KEY',  '$dxu*Lq}h8oy:v@jFQ]^ygbb#H5+2&WB8s1ito<nV@[OBe^6{y)YQCE2&23*$t|%' );
define( 'LOGGED_IN_KEY',    'nHc;SS#WwrXzI3z?+:?{@A*Njr^cQ.ITgLzOrB]Hc[i;pr(;S,hB* S+bw[,on V' );
define( 'NONCE_KEY',        '1*Klym-!X+I#?P!%l8#&T_)f9h&W^6DR8)Ue/ahi:~3q{ %9F,@$!kS?mgn7.467' );
define( 'AUTH_SALT',        'L8+D7j$ls9y)a<j+G2LAcOiG&*9^.=Hm+V]]%:l[nDbSWFiM94`.[Oo|`7%zlW~q' );
define( 'SECURE_AUTH_SALT', 'rG=d}s(.tozsXm$obes$OVkNR,&!)2pf}O.FSB#+=sERH8asyXHJ:Xz=,E=SZn-+' );
define( 'LOGGED_IN_SALT',   'U{|_6uDtf/5 HQT?UGlqf<YBC;LwL4hN^b!(,dJdGW.g|suC8]r@YAxv|Khv24k1' );
define( 'NONCE_SALT',       '<#S>Xko?{%6s}|Fpz)dG+C#[3SN=u/M1t4z4#R73V{X2D;)%`u/vbO{q*:i>`5j@' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
