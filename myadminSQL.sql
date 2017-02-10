# Dump da tabela sis_basic_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sis_basic_info`;

CREATE TABLE `sis_basic_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `basic_meta_keywords` text,
  `basic_meta_descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `sis_basic_info` WRITE;
/*!40000 ALTER TABLE `sis_basic_info` DISABLE KEYS */;

INSERT INTO `sis_basic_info` (`id`, `title`, `basic_meta_keywords`, `basic_meta_descricao`)
VALUES
	(1,'My Admin','my,admin','Lorem ipsum dolor sit amet consectetur adisciping elit.');

/*!40000 ALTER TABLE `sis_basic_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela sis_campo_modulo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sis_campo_modulo`;

CREATE TABLE `sis_campo_modulo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `valor_padrao` text COLLATE utf8_unicode_ci,
  `tipo_campo` enum('I','T','D','DT','N','S','SI') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'I',
  `id_modulo` int(11) NOT NULL,
  `listagem` tinyint(1) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump da tabela sis_modulos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sis_modulos`;

CREATE TABLE `sis_modulos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_tipo_modulo` int(11) NOT NULL,
  `rota` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `item_modulo` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `items_modulo` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `imagem` tinyint(1) DEFAULT NULL,
  `galeria` tinyint(1) DEFAULT NULL,
  `nome_tabela` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump da tabela sis_tipos_modulo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sis_tipos_modulo`;

CREATE TABLE `sis_tipos_modulo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `controller_admin` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_admin_index` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_admin_form` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rotas` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `sis_tipos_modulo` WRITE;
/*!40000 ALTER TABLE `sis_tipos_modulo` DISABLE KEYS */;

INSERT INTO `sis_tipos_modulo` (`id`, `nome`, `controller_admin`, `model`, `view_admin_index`, `view_admin_form`, `rotas`)
VALUES
	(1,'Complexo','controller_admin_com_detalhe.php','model_com_detalhe.php','view_admin_index_com_detalhe.php','view_admin_form_com_detalhe.php','rotas_com_detalhe.php'),
	(2,'Simples','controller_admin_sem_detalhe.php','model_sem_detalhe.php','view_admin_index_sem_detalhe.php','','rotas_sem_detalhe.php');

/*!40000 ALTER TABLE `sis_tipos_modulo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `id_user_group` int(11) DEFAULT NULL,
  `thumbnail_principal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_users_groups` (`id_user_group`),
  CONSTRAINT `fk_users_users_groups` FOREIGN KEY (`id_user_group`) REFERENCES `users_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `name`, `updated_at`, `created_at`, `remember_token`, `id_user_group`, `thumbnail_principal`)
VALUES
	(2,'jose@bf2tecnologia.com.br','$2y$10$nAUah1gTNNdInhkTbBZPKeF2RxU2YwWW0N15LsBGWxAFgTLIjFu0m','José BF2',NULL,NULL,NULL,1,'thumb_1486766788-jose.jpg');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;

INSERT INTO `users_groups` (`id`, `nome`)
VALUES
	(1,'Master'),
	(2,'Usuário');

/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
