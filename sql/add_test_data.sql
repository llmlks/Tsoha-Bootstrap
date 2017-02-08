INSERT INTO Band (bandname, description, origin, username, password) VALUES 
('The Band', 'The Band was formed in 2010 by siblings Alice and Eoghan. 
They have so far released three singles and one LP, as well as toured some of 
the biggest summer festivals in Europe. Their music is partly inspired by 
Nirvana, The Red Hot Chilli Peppers and their likes.', 'United Kingdom', 
'theband', '12345689');
INSERT INTO Band (bandname, username, password) VALUES ('Smaller Band', 'smallband', 'smallband123');

INSERT INTO BandFavourite (band_id, favourite) VALUES (1, 2);

INSERT INTO Genre (genrename) VALUES ('metal');
INSERT INTO Genre (genrename) VALUES ('funk');

INSERT INTO BandGenre (band_id, genre_id) VALUES (1, 2);
INSERT INTO BandGenre (band_id, genre_id) VALUES (2, 2);

INSERT INTO BandLink (band_id, linkname, url) VALUES (1, 'Google', 'http://google.com');

INSERT INTO Concert (band_id, gigtime, gigdate, location) VALUES (2, '01:00', '28.02.2016', 'Klubi, Tampere');

INSERT INTO Member (band_id, membername, instruments, joined) VALUES (1, 'Anna', 'didgeridoo', date '2010-03-17');