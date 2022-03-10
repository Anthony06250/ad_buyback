CREATE TABLE IF NOT EXISTS `PREFIX_ad_buyback` (
    `id_ad_buyback` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_customer` int(11) UNSIGNED DEFAULT NULL,
    `id_gender` int(11) UNSIGNED NOT NULL,
    `firstname` varchar(255) DEFAULT NULL,
    `lastname` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `active` int(2) UNSIGNED NOT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY  (`id_ad_buyback`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ad_buyback_image` (
    `id_ad_buyback_image` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_ad_buyback` int(11) UNSIGNED NOT NULL,
    `name` varchar(128) NOT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY (`id_ad_buyback_image`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ad_buyback_chat` (
    `id_ad_buyback_chat` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_ad_buyback` int(11) UNSIGNED NOT NULL,
    `active` int(2) UNSIGNED NOT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    `token` varchar(32) NOT NULL,
    PRIMARY KEY (`id_ad_buyback_chat`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ad_buyback_message` (
    `id_ad_buyback_message` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_ad_buyback_chat` int(11) UNSIGNED NOT NULL,
    `id_customer` int(11) UNSIGNED DEFAULT NULL,
    `id_employee` int(11) UNSIGNED DEFAULT NULL,
    `message` text DEFAULT NULL,
    `active` int(2) UNSIGNED NOT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY (`id_ad_buyback_message`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
