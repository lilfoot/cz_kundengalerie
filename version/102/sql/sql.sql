create table xplugin_cz_kundengalerie_kunden_artikel (
	kArtikelGekauft int not null primary key auto_increment,
	kKunde int not null,
    kArtikel int not null,
    dEingetragen datetime not null,
    dMailVersendet datetime not null
);