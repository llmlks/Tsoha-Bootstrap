INSERT INTO Band (bandname, username, password) VALUES ('The Band', 'theband', '12345689');
INSERT INTO Band (bandname, username, password) VALUES ('Smaller Band', 'smallband', 'smallband123');

INSERT INTO BandFavourite (band_id, favourite) VALUES (1, 2);

INSERT INTO Genre (genrename) VALUES ('metal');
INSERT INTO Genre (genrename) VALUES ('funk');

INSERT INTO BandGenre (band_id, genre_id) VALUES (1, 2);
INSERT INTO BandGenre (band_id, genre_id) VALUES (2, 2);

INSERT INTO BandLink (band_id, linkname, url) VALUES (1, 'Google', 'http://google.com');

INSERT INTO Concert (band_id, gigtime, gigdate, location) VALUES (2, time '01:00', date '2017-10-28', 'Klubi, Tampere');

INSERT INTO Member (band_id, membername, instruments, joined) VALUES (1, 'Anna', 'didgeridoo', date '2010-03-17');