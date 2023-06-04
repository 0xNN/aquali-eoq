/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - aquali
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `barang_masuks` */

DROP TABLE IF EXISTS `barang_masuks`;

CREATE TABLE `barang_masuks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pembelian_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `barang_masuks` */

insert  into `barang_masuks`(`id`,`pembelian_id`,`barang_id`,`jumlah`,`user_id`,`created_at`,`updated_at`) values 
(1,1,9,3,1,'2023-05-31 07:37:37','2023-05-31 07:37:37'),
(2,3,6,100,1,'2023-06-03 13:30:31','2023-06-03 13:30:31'),
(3,5,9,200,2,'2023-06-03 14:47:31','2023-06-03 14:47:31');

/*Table structure for table `barangs` */

DROP TABLE IF EXISTS `barangs`;

CREATE TABLE `barangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `penggunaan_tahun` int(11) NOT NULL DEFAULT 0,
  `stok` int(11) NOT NULL DEFAULT 0,
  `safety_stok` int(11) NOT NULL DEFAULT 0,
  `eoq` int(11) NOT NULL DEFAULT 0,
  `rop` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `barangs` */

insert  into `barangs`(`id`,`kode_barang`,`nama_barang`,`kategori_id`,`rule_id`,`harga_beli`,`harga_jual`,`penggunaan_tahun`,`stok`,`safety_stok`,`eoq`,`rop`,`gambar`,`keterangan`,`created_at`,`updated_at`) values 
(1,'B001','Barang A',2,0,3900,6000,22000,110,20,133,0,NULL,NULL,'2023-05-23 06:34:55','2023-05-23 12:21:27'),
(3,'B002','Barang B',1,0,2500,5500,0,4000,0,0,0,'1684827268_602847.jpg',NULL,'2023-05-23 07:13:00','2023-05-23 07:34:28'),
(6,'B003','Kain Karembong',2,0,3000,6000,30000,-105,20,155,0,NULL,NULL,'2023-05-23 10:12:30','2023-06-03 13:31:27'),
(7,'B004','Surpet',2,0,100000,120000,4000,100,300,57,0,NULL,NULL,'2023-05-23 10:54:58','2023-05-23 10:54:58'),
(8,'B005','Barang BB',1,0,0,2000,0,200,100,0,0,NULL,NULL,'2023-05-23 10:55:43','2023-05-23 10:55:43'),
(9,'CUP001','Cup 200 ml',2,2,120,0,33696000,1103,33305161,390839,33306721,NULL,NULL,'2023-05-23 13:10:07','2023-06-03 14:47:31');

/*Table structure for table `distribusis` */

DROP TABLE IF EXISTS `distribusis`;

CREATE TABLE `distribusis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permintaan_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `distribusis` */

insert  into `distribusis`(`id`,`permintaan_id`,`barang_id`,`jumlah`,`user_id`,`keterangan`,`created_at`,`updated_at`) values 
(1,1,9,100,1,NULL,'2023-06-03 13:27:59','2023-06-03 13:27:59'),
(2,3,6,200,1,NULL,'2023-06-03 13:31:06','2023-06-03 13:31:06'),
(3,3,6,5,1,NULL,'2023-06-03 13:31:27','2023-06-03 13:31:27');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `kategoris` */

DROP TABLE IF EXISTS `kategoris`;

CREATE TABLE `kategoris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_eoq` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kategoris` */

insert  into `kategoris`(`id`,`nama_kategori`,`is_eoq`,`created_at`,`updated_at`) values 
(1,'Barang Produksi',0,'2023-05-22 18:58:16','2023-05-23 10:50:39'),
(2,'Barang Baku',1,'2023-05-22 18:58:20','2023-05-22 18:58:20');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2023_05_22_173937_create_barangs_table',2),
(6,'2023_05_22_174102_create_kategoris_table',3),
(7,'2023_05_22_174505_create_suppliers_table',3),
(8,'2023_05_22_174521_create_rules_table',3),
(9,'2023_05_27_103235_create_pembelians_table',4),
(10,'2023_05_27_104010_create_pembelian_details_table',4),
(11,'2023_05_28_125150_create_barang_masuks_table',5),
(12,'2023_05_31_074351_create_permintaans_table',6),
(13,'2023_05_31_074738_create_permintaan_details_table',6),
(14,'2023_06_03_115528_create_distribusis_table',7);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `pembelian_details` */

DROP TABLE IF EXISTS `pembelian_details`;

CREATE TABLE `pembelian_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pembelian_id` int(11) NOT NULL,
  `kode_pembelian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pembelian_details` */

insert  into `pembelian_details`(`id`,`pembelian_id`,`kode_pembelian`,`barang_id`,`jumlah`,`harga_satuan`,`harga_total`,`tanggal_diterima`,`created_at`,`updated_at`) values 
(1,1,'PB-1685190138657',9,3,120,360,NULL,'2023-05-27 12:36:45','2023-05-27 12:36:45'),
(2,2,'PB-1685191705534',6,65,3000,195000,NULL,'2023-05-27 12:48:33','2023-05-27 12:48:33'),
(3,2,'PB-1685191705534',9,34,120,4080,NULL,'2023-05-27 12:48:33','2023-05-27 12:48:33'),
(4,3,'PB-1685798948052',6,100,3000,300000,NULL,'2023-06-03 13:29:16','2023-06-03 13:29:16'),
(5,4,'PB-1685803469547',9,100,120,12000,NULL,'2023-06-03 14:44:41','2023-06-03 14:44:41'),
(6,5,'PB-1685803515213',9,200,120,24000,NULL,'2023-06-03 14:45:22','2023-06-03 14:45:22');

/*Table structure for table `pembelians` */

DROP TABLE IF EXISTS `pembelians`;

CREATE TABLE `pembelians` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_pembelian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `status_permintaan` int(11) NOT NULL DEFAULT 0 COMMENT '0: permintaan, 1: disetujui, 2: ditolak',
  `status_pembelian` int(11) NOT NULL DEFAULT 0 COMMENT '0: belum diterima, 1: diterima',
  `tanggal_permintaan` date NOT NULL,
  `tanggal_pembelian` date DEFAULT NULL,
  `user_id_permintaan` int(11) NOT NULL,
  `user_id_pembelian` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pembelians` */

insert  into `pembelians`(`id`,`kode_pembelian`,`supplier_id`,`status_permintaan`,`status_pembelian`,`tanggal_permintaan`,`tanggal_pembelian`,`user_id_permintaan`,`user_id_pembelian`,`created_at`,`updated_at`) values 
(1,'PB-1685190138657',2,1,1,'2023-05-27',NULL,1,NULL,'2023-05-27 12:36:45','2023-05-28 12:35:47'),
(2,'PB-1685191705534',2,1,1,'2023-05-27',NULL,1,NULL,'2023-05-27 12:48:33','2023-05-28 12:40:30'),
(3,'PB-1685798948052',2,1,1,'2023-06-03',NULL,1,NULL,'2023-06-03 13:29:16','2023-06-03 13:29:31'),
(4,'PB-1685803469547',2,0,0,'2023-06-03',NULL,2,NULL,'2023-06-03 14:44:41','2023-06-03 14:44:41'),
(5,'PB-1685803515213',2,1,1,'2023-06-03',NULL,4,NULL,'2023-06-03 14:45:22','2023-06-03 14:46:47');

/*Table structure for table `permintaan_details` */

DROP TABLE IF EXISTS `permintaan_details`;

CREATE TABLE `permintaan_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_permintaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permintaan_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan_details` */

insert  into `permintaan_details`(`id`,`kode_permintaan`,`permintaan_id`,`barang_id`,`jumlah`,`created_at`,`updated_at`) values 
(1,'PM-1685543276725',1,9,100,'2023-05-31 14:28:02','2023-05-31 14:28:02'),
(2,'PM-1685714823473',2,9,2,'2023-06-02 14:07:10','2023-06-02 14:07:10'),
(3,'PM-1685798910499',3,6,205,'2023-06-03 13:28:56','2023-06-03 13:28:56'),
(4,'PM-1685803380075',4,9,100,'2023-06-03 14:43:15','2023-06-03 14:43:15');

/*Table structure for table `permintaans` */

DROP TABLE IF EXISTS `permintaans`;

CREATE TABLE `permintaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_permintaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0: Belum diproses, 1: Disetujui, 2: Ditolak',
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaans` */

insert  into `permintaans`(`id`,`kode_permintaan`,`status`,`keterangan`,`user_id`,`created_at`,`updated_at`) values 
(1,'PM-1685543276725',1,NULL,1,'2023-05-31 14:28:02','2023-06-03 11:40:03'),
(2,'PM-1685714823473',2,'Tes',1,'2023-06-02 14:07:10','2023-06-03 11:41:00'),
(3,'PM-1685798910499',1,'Tes',1,'2023-06-03 13:28:56','2023-06-03 13:30:55'),
(4,'PM-1685803380075',1,'Permintaan 1',3,'2023-06-03 14:43:15','2023-06-03 14:53:13');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `rules` */

DROP TABLE IF EXISTS `rules`;

CREATE TABLE `rules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `biaya_pemesanan` int(11) NOT NULL DEFAULT 0,
  `biaya_penyimpanan` int(11) NOT NULL DEFAULT 0,
  `lead_time` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `rules` */

insert  into `rules`(`id`,`biaya_pemesanan`,`biaya_penyimpanan`,`lead_time`,`created_at`,`updated_at`) values 
(2,6800,3,5,'2023-05-23 09:42:21','2023-05-23 13:19:09'),
(3,7300,4,5,'2023-05-23 09:42:21','2023-05-23 13:19:09');

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id`,`nama_supplier`,`alamat`,`kota`,`telepon`,`email`,`website`,`created_at`,`updated_at`) values 
(2,'PT A','Jl. Griya Interbis Indah. Blok.B. No.12A. Kel. Talang Kelapa','Kota Palembang','081377519655',NULL,NULL,'2023-05-23 08:37:05','2023-05-23 08:37:05');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`role`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','admin@aquali.com','admin',NULL,'$2y$10$swfPh0H4kGVVY6knjUdmHeg.vaKU.6n1r0Pp3BqhoUXe2Bwssukku',NULL,'2023-05-21 13:06:36','2023-05-21 13:06:36'),
(2,'gudang','gudang@aquali.com','gudang',NULL,'$2y$10$FS2sdCXetYadIzQmavlsG.DqM7hvjDdY2N7/8UoHqE1L6X2hhT8Di',NULL,'2023-05-21 13:06:36','2023-05-21 13:06:36'),
(3,'produksi','produksi@aquali.com','produksi',NULL,'$2y$10$U7wmmMOQqX3HGAWu7wZB7eOFymhLBqysVak3hYBtiUZt3z6PyEmYK',NULL,NULL,NULL),
(4,'keuangan','pembelian@aquali.com','keuangan',NULL,'$2y$10$iM5uuW1plpstkQT0PmvAf.fAwTEJR.XkoUbKpbCeFR3nKFfq0aoWq',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
