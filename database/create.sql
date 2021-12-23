create schema ccca;

create sequence ccca.order_sequence as integer;

create table ccca.item
(
    id_item     serial primary key,
    category    text,
    description text,
    price       numeric,
    width       integer,
    height      integer,
    length      integer,
    weight      numeric
);

insert into ccca.item (id_item, category, description, price, width, height, length, weight) values (1, 'Música', 'CD', 1000, 20, 15, 10, 1);
insert into ccca.item (id_item, category, description, price, width, height, length, weight) values (2, 'Vídeo', 'DVD', 50, 100, 30, 10, 3);
insert into ccca.item (id_item, category, description, price, width, height, length, weight) values (3, 'Vídeo', 'VHS', 25, 200, 100, 50, 40);
insert into ccca.item (id_item, category, description, price, width, height, length, weight) values (4, 'Instrumentos Musicais', 'Guitarra', 1000, 100, 30, 10, 3);
insert into ccca.item (id_item, category, description, price, width, height, length, weight) values (5, 'Instrumentos Musicais', 'Amplificador', 5000, 100, 50, 50, 20);
insert into ccca.item (id_item, category, description, price, width, height, length, weight) values (6, 'Acessórios', 'Cabo', 30, 10, 10, 10, 1);

create table ccca.coupon
(
    code        text not null primary key,
    percentage  numeric,
    expire_date timestamp
);

insert into ccca.coupon (code, percentage, expire_date) values ('VALE10', 10, '2021-12-23T10:00:00');
insert into ccca.coupon (code, percentage, expire_date) values ('VALE20', 20, '2021-12-21T10:00:00');

create table ccca.order
(
    id_order   serial primary key,
    coupon     text,
    code       text,
    cpf        text,
    issue_date timestamp,
    freight    numeric,
    sequence   integer
);

create table ccca.order_item
(
    id_order integer not null,
    id_item  integer not null,
    price    numeric,
    quantity integer,
    primary key (id_order, id_item)
);

