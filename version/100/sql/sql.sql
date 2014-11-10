create table xplugin_cz_kundengalerie_bilder (
	kKundenbild int not null primary key auto_increment,
    kArtikel int not null,
    kKunde int not null,
    cFilename varchar(255) not null,
    cKundenkommentar longtext,
    bKundenkommentarAnzeigen enum('y','n') default 'n',
    bAktiv enum('y','n') default 'n',
    dEingetragen datetime not null
);