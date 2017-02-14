CREATE TABLE Band (
    id SERIAL PRIMARY KEY,
    bandname varchar(50) NOT NUll,
    description varchar(1000),
    origin varchar(100),
    likes integer DEFAULT 0,
    username varchar(50) UNIQUE NOT NULL,
    password varchar(20) NOT NULL
);

CREATE TABLE Genre (
    id SERIAL PRIMARY KEY,
    genrename varchar(50) NOT NULL
);

CREATE TABLE BandGenre (
    band_id INTEGER REFERENCES Band(id),
    genre_id INTEGER REFERENCES Genre(id),
    PRIMARY KEY(band_id, genre_id)
);

CREATE TABLE Concert (
    id SERIAL PRIMARY KEY,
    band_id INTEGER REFERENCES Band(id),
    gigtime time NOT NULL,
    gigdate date NOT NULL,
    location varchar(100) NOT NULL
);

CREATE TABLE BandFavourite (
    band_id INTEGER REFERENCES Band(id),
    favourite INTEGER REFERENCES Band(id),
    PRIMARY KEY(band_id, favourite)
);

CREATE TABLE BandLink (
    id SERIAL PRIMARY KEY,
    band_id INTEGER REFERENCES Band(id),
    linkname varchar(50) NOT NULL,
    url varchar(70) NOT NULL
);

CREATE TABLE Member (
    id SERIAL PRIMARY KEY,
    band_id INTEGER REFERENCES Band(id) NOT NULL,
    membername varchar(50) NOT NULL,
    instruments varchar(100) NOT NULL,
    joined date NOT NULL,
    resigned date
);