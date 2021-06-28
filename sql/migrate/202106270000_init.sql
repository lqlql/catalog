create table products
(
    productId int unsigned auto_increment
        primary key,
    title     varchar(255)             not null,
    price     int unsigned             not  null,
    createdDt int unsigned             null,
    updatedDt int unsigned             null,
    isDeleted tinyint      default 0   null,
    constraint products_title_uindex
        unique (title)
);

create index products_isDeleted_index
    on products (isDeleted);


create table carts
(
    productId int not null,
    userId int not null,
    count int not null,
    constraint carts_pk
        unique (productId, userId)
);





