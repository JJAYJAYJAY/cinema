create table cinema
(
    name text null
);

create table commits
(
    who     text null,
    content text null,
    time    text null
);

create table users
(
    username text not null,
    password text not null,
    identity text not null,
    email    text null,
    phone    text null
);


