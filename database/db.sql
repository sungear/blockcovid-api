DROP SCHEMA IF EXISTS pfe CASCADE; --for testing--
CREATE SCHEMA pfe;				   --for testing--
----------- TABLES CREATION ----------->
CREATE TABLE pfe.createurs_de_qr (
	id_createur_de_qr SERIAL PRIMARY KEY,
	email VARCHAR(50) NOT NULL UNIQUE,
	numero VARCHAR(50) NULL,
	mot_de_passe VARCHAR(100) NOT NULL,
	type_createur CHAR(1) NOT NULL
);

CREATE TABLE pfe.medecins (
	id_createur_de_qr INT PRIMARY KEY REFERENCES pfe.createurs_de_qr(id_createur_de_qr),
	nom VARCHAR(50) NOT NULL,
	prenom VARCHAR(50) NOT NULL
);

CREATE TABLE pfe.qr_medecins(
	id_qr_medecin SERIAL PRIMARY KEY,
	id_createur_de_qr INT REFERENCES pfe.medecins(id_createur_de_qr),
	est_scan BOOLEAN
);

CREATE TABLE pfe.etablissements (
	id_createur_de_qr INT PRIMARY KEY REFERENCES pfe.createurs_de_qr(id_createur_de_qr),
	nom VARCHAR(50) NOT NULL,
	adresse VARCHAR(50) NOT NULL
);

CREATE TABLE pfe.qr_etablissements(
	id_qr_etablissement SERIAL PRIMARY KEY,
	id_createur_de_qr INT REFERENCES pfe.etablissements(id_createur_de_qr),
	nom VARCHAR(50) NULL,
	description VARCHAR(50) NULL
);

CREATE TABLE pfe.citoyens(
	id_citoyen SERIAL PRIMARY KEY
);

CREATE TABLE pfe.frequentations(
	id_citoyen INT REFERENCES pfe.citoyens(id_citoyen),
	id_qr_etablissement INT REFERENCES pfe.qr_etablissements(id_qr_etablissement),
	date_frequentation TIMESTAMP NOT NULL DEFAULT now(),
	CONSTRAINT id_frequentation PRIMARY KEY (id_citoyen, id_qr_etablissement, date_frequentation)
);

--============================================================== createurs_de_qr ==========================================================================--
INSERT INTO pfe.createurs_de_qr VALUES (DEFAULT, 'userdoc@fakemail.com', '027777777', 'azerty', 'M');
INSERT INTO pfe.createurs_de_qr VALUES (DEFAULT, 'useretab@fakemail.com', '028888888', 'qwerty', 'E');
--============================================================== medecins ==========================================================================--
INSERT INTO pfe.medecins VALUES ('1', 'docteurnom', 'docteurprenom');
--============================================================== qr_medecins ==========================================================================--
INSERT INTO pfe.qr_medecins VALUES (DEFAULT, '1', FALSE);
--============================================================== etablissements ==========================================================================--
INSERT INTO pfe.etablissements VALUES ('2', 'etablissementnom', 'adresseetablissement');
--============================================================== qr_etablissements ==========================================================================--
INSERT INTO pfe.qr_etablissements VALUES (DEFAULT, '2', NULL, 'testdescription');
--============================================================== citoyens ==========================================================================--
INSERT INTO pfe.citoyens VALUES (DEFAULT);
--============================================================== frequentations ==========================================================================--
INSERT INTO pfe.frequentations VALUES ('1', '1', '2020-12-02 15:01:55');


