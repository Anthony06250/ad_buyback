CREATE TABLE IF NOT EXISTS `PREFIX_ad_buyback` (
    `id_ad_buyback` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `firstname` varchar(255) DEFAULT NULL,
    `lastname` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `active` int(2) UNSIGNED NOT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY  (`id_ad_buyback`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ad_buyback_image` (
    `id_ad_buyback_image` int(11) NOT NULL AUTO_INCREMENT,
    `id_ad_buyback` int(11) NOT NULL,
    `name` varchar(64) NOT NULL,
    PRIMARY KEY (`id_ad_buyback_image`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;
