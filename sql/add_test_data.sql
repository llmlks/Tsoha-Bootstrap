INSERT INTO Band (bandname, description, origin, username, password) VALUES 
('The Band', 'The Band was formed in 2010 by siblings Alice and Eoghan. 
They have so far released three singles and one LP, as well as toured some of 
the biggest summer festivals in Europe. Their music is partly inspired by 
Nirvana, The Red Hot Chilli Peppers and their likes.', 'United Kingdom', 
'theband', '12345689');
INSERT INTO Band (bandname, username, password) VALUES ('Smaller Band', 'smallband', 'smallband123');

INSERT INTO BandFavourite (band_id, favourite) VALUES (1, 2);

INSERT INTO Genre (genrename) VALUES ('Metal');
INSERT INTO Genre (genrename) VALUES ('Funk');
INSERT INTO Genre (genrename) VALUES ('Pop');
INSERT INTO Genre (genrename) VALUES ('Jazz');
INSERT INTO Genre (genrename) VALUES ('Blues');
INSERT INTO Genre (genrename) VALUES ('Soul');
INSERT INTO Genre (genrename) VALUES ('Reggae');
INSERT INTO Genre (genrename) VALUES ('Psychedelic');
INSERT INTO Genre (genrename) VALUES ('Ambient');
INSERT INTO Genre (genrename) VALUES ('Rap');
INSERT INTO Genre (genrename) VALUES ('Classical');
INSERT INTO Genre (genrename) VALUES ('Punk');
INSERT INTO Genre (genrename) VALUES ('R&B');
INSERT INTO Genre (genrename) VALUES ('Noise');

INSERT INTO BandGenre (band_id, genre_id) VALUES (1, 2);
INSERT INTO BandGenre (band_id, genre_id) VALUES (2, 2);

INSERT INTO BandLink (band_id, linkname, url) VALUES (1, 'Google', 'http://google.com');

INSERT INTO Concert (band_id, gigtime, gigdate, location) VALUES (2, time '01:00', date '2017-10-28', 'Klubi, Tampere');

INSERT INTO Member (band_id, membername, instruments, joined) VALUES (1, 'Anna', 'didgeridoo', date '2010-03-17');