DROP SCHEMA IF EXISTS pfe CASCADE; --for testing--
CREATE SCHEMA pfe;				   --for testing--
----------- TABLES CREATION ----------->
CREATE TABLE pfe.createurs_de_qr (
	id_createur_de_qr VARCHAR(255) PRIMARY KEY,
	email VARCHAR(50) NOT NULL UNIQUE 
	CHECK(email SIMILAR TO '[a-zA-Z0-9]+([\.\-]*[a-zA-Z0-9]*)*@[a-zA-Z]+[\.][a-zA-Z]+([\.][a-zA-Z]+)?'),
	numero VARCHAR(256) CHECK(numero SIMILAR TO '[+]?[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*'),
	mot_de_passe VARCHAR(100) NOT NULL CHECK(mot_de_passe <> ''),
	type_createur CHAR(1) NOT NULL CHECK(type_createur = 'M' OR type_createur = 'E')
);

CREATE TABLE pfe.medecins (
	id_createur_de_qr VARCHAR(255) PRIMARY KEY REFERENCES pfe.createurs_de_qr(id_createur_de_qr),
	nom VARCHAR(50) NOT NULL CHECK(nom <> ''),
	prenom VARCHAR(50) NOT NULL CHECK(prenom <> '')
);

CREATE TABLE pfe.qr_medecins(
	id_qr_medecin VARCHAR(255) PRIMARY KEY,
	id_createur_de_qr VARCHAR(255) NOT NULL REFERENCES pfe.medecins(id_createur_de_qr),
	est_scan BOOLEAN NOT NULL DEFAULT false
);

CREATE TABLE pfe.etablissements (
	id_createur_de_qr VARCHAR(255) PRIMARY KEY REFERENCES pfe.createurs_de_qr(id_createur_de_qr),
	nom VARCHAR(50) NOT NULL CHECK(nom <> ''),
	adresse VARCHAR(50) NOT NULL CHECK(nom <> '')
);

CREATE TABLE pfe.qr_etablissements(
	id_qr_etablissement VARCHAR(255) PRIMARY KEY,
	id_createur_de_qr VARCHAR(255) NOT NULL REFERENCES pfe.etablissements(id_createur_de_qr),
	nom VARCHAR(50),
	description VARCHAR(50)
);

CREATE TABLE pfe.citoyens(
	id_citoyen VARCHAR(255) PRIMARY KEY,
    token_fcm VARCHAR(255) NOT NULL UNIQUE CHECK(token_fcm <> '')
);

CREATE TABLE pfe.frequentations(
	id_citoyen VARCHAR(255) NOT NULL REFERENCES pfe.citoyens(id_citoyen),
	id_qr_etablissement VARCHAR(255) NOT NULL REFERENCES pfe.qr_etablissements(id_qr_etablissement),
	date_frequentation TIMESTAMP NOT NULL DEFAULT now(),
	CONSTRAINT id_frequentation PRIMARY KEY (id_citoyen, id_qr_etablissement, date_frequentation)
);

--============================================================== createurs_de_qr ==========================================================================--
INSERT INTO pfe.createurs_de_qr VALUES ('1', 'userdoc@fakemail.com', '027777777', 'azerty', 'M');
INSERT INTO pfe.createurs_de_qr VALUES ('2', 'useretab@fakemail.com', '028888888', 'qwerty', 'E');
--============================================================== medecins ==========================================================================--
INSERT INTO pfe.medecins VALUES ('1', 'docteurnom', 'docteurprenom');
--============================================================== qr_medecins ==========================================================================--
INSERT INTO pfe.qr_medecins VALUES ('1', '1', FALSE);
--============================================================== etablissements ==========================================================================--
INSERT INTO pfe.etablissements VALUES ('2', 'etablissementnom', 'adresseetablissement');
--============================================================== qr_etablissements ==========================================================================--
INSERT INTO pfe.qr_etablissements VALUES ('1', '2', NULL, 'testdescription');
--============================================================== citoyens ==========================================================================--
INSERT INTO pfe.citoyens VALUES ('1', 'token1');
--============================================================== frequentations ==========================================================================--
INSERT INTO pfe.frequentations VALUES ('1', '1', '2020-12-02 15:01:55');