
/*==============================================================*/
/* Table: M_BARANG                                              */
/*==============================================================*/
create table M_BARANG 
(
   ID_BARANG            integer                        not null,
   NAMA_BARANG          varchar(200)                   null,
   KETERANGAN           long varchar                   null,
   HARGA                integer                        null,
   AKTIF                char(5)                        null,
   constraint PK_M_BARANG primary key (ID_BARANG)
);

/*==============================================================*/
/* Index: M_BARANG_PK                                           */
/*==============================================================*/
create unique index M_BARANG_PK on M_BARANG (
ID_BARANG ASC
);

/*==============================================================*/
/* Table: M_CUSTOMER                                            */
/*==============================================================*/
create table M_CUSTOMER 
(
   ID_CUSTOMER          integer                        not null,
   NAMA_CUSTOMER        varchar(50)                    null,
   ALAMAT_CUSTOMER      varchar(150)                   null,
   EMAIL_CUSTOMER       varchar(75)                    null,
   HP_CUSTOMER          varchar(16)                    null,
   USERNAME             varchar(15)                    null,
   PASSWORD             varchar(50)                    null,
   AKTIF                char(5)                        null,
   constraint PK_M_CUSTOMER primary key (ID_CUSTOMER)
);

/*==============================================================*/
/* Index: M_CUSTOMER_PK                                         */
/*==============================================================*/
create unique index M_CUSTOMER_PK on M_CUSTOMER (
ID_CUSTOMER ASC
);

/*==============================================================*/
/* Table: M_KARTU                                               */
/*==============================================================*/
create table M_KARTU 
(
   ID_KARTU             integer                        not null,
   NOMOR_RFID           varchar(10)                    null,
   JUMLAH_UANG          integer                        null,
   constraint PK_M_KARTU primary key (ID_KARTU)
);

/*==============================================================*/
/* Index: M_KARTU_PK                                            */
/*==============================================================*/
create unique index M_KARTU_PK on M_KARTU (
ID_KARTU ASC
);

/*==============================================================*/
/* Table: T_DETAIL_KARTU                                        */
/*==============================================================*/
create table T_DETAIL_KARTU 
(
   ID_DETAIL_KARTU      integer                        not null,
   TGL_PAKAI            timestamp                      null,
   constraint PK_T_DETAIL_KARTU primary key (ID_DETAIL_KARTU)
);

/*==============================================================*/
/* Index: T_DETAIL_KARTU_PK                                     */
/*==============================================================*/
create unique index T_DETAIL_KARTU_PK on T_DETAIL_KARTU (
ID_DETAIL_KARTU ASC
);

/*==============================================================*/
/* Table: T_DETAIL_ORDER                                        */
/*==============================================================*/
create table T_DETAIL_ORDER 
(
   ID_DETAIL_ORDER      integer                        not null,
   ID_T_ORDER           integer                        null,
   ID_BARANG            integer                        null,
   HARGA                integer                        null,
   TGL_DETAIL_ORDER     timestamp                      null,
   constraint PK_T_DETAIL_ORDER primary key (ID_DETAIL_ORDER)
);

/*==============================================================*/
/* Index: T_DETAIL_ORDER_PK                                     */
/*==============================================================*/
create unique index T_DETAIL_ORDER_PK on T_DETAIL_ORDER (
ID_DETAIL_ORDER ASC
);

/*==============================================================*/
/* Index: RELATIONSHIP_2_FK                                     */
/*==============================================================*/
create index RELATIONSHIP_2_FK on T_DETAIL_ORDER (
ID_T_ORDER ASC
);

/*==============================================================*/
/* Index: RELATIONSHIP_6_FK                                     */
/*==============================================================*/
create index RELATIONSHIP_6_FK on T_DETAIL_ORDER (
ID_BARANG ASC
);

/*==============================================================*/
/* Table: T_ORDER                                               */
/*==============================================================*/
create table T_ORDER 
(
   ID_T_ORDER           integer                        not null,
   ID_CUSTOMER          integer                        null,
   TGL_ORDER            timestamp                      null,
   KETERANGAN           long varchar                   null,
   JUMLAH_HARGA         integer                        null,
   constraint PK_T_ORDER primary key (ID_T_ORDER)
);

/*==============================================================*/
/* Index: T_ORDER_PK                                            */
/*==============================================================*/
create unique index T_ORDER_PK on T_ORDER (
ID_T_ORDER ASC
);

/*==============================================================*/
/* Index: RELATIONSHIP_5_FK                                     */
/*==============================================================*/
create index RELATIONSHIP_5_FK on T_ORDER (
ID_CUSTOMER ASC
);

/*==============================================================*/
/* Table: T_PAKAI_KARTU                                         */
/*==============================================================*/
create table T_PAKAI_KARTU 
(
   ID_PAKAI_KARTU       integer                        not null,
   TGL_PAKAI            timestamp                      null,
   HARGA                integer                        null,
   constraint PK_T_PAKAI_KARTU primary key (ID_PAKAI_KARTU)
);

