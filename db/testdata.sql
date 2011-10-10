insert into quotes set quote_text='quote 1', created=NOW();
insert into quotes set quote_text='quote 2', created=NOW();
insert into quotes set quote_text='quote 3', created=NOW();
insert into quotes set quote_text='quote 4', created=NOW();

select * from quotes;


insert into votes set quote_id=1, ip_addr='255.255.255.255', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.254', vote=-1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.253', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.252', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.251', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.250', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.247', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.246', vote=-1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.245', vote=-1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.244', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.243', vote=1, created=NOW();
insert into votes set quote_id=1, ip_addr='255.255.255.242', vote=1, created=NOW();

select sum(vote) from votes where quote_id=1;

insert into votes set quote_id=2, ip_addr='255.255.255.255', vote=1, created=NOW();
insert into votes set quote_id=2, ip_addr='255.255.255.254', vote=1, created=NOW();
insert into votes set quote_id=2, ip_addr='255.255.255.253', vote=-1, created=NOW();
insert into votes set quote_id=2, ip_addr='255.255.255.252', vote=-1, created=NOW();
insert into votes set quote_id=2, ip_addr='255.255.255.251', vote=1, created=NOW();
insert into votes set quote_id=2, ip_addr='255.255.255.250', vote=1, created=NOW();
insert into votes set quote_id=2, ip_addr='255.255.255.247', vote=1, created=NOW();

select sum(vote) from votes where quote_id=2;

insert into votes set quote_id=3, ip_addr='255.255.255.255', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.254', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.253', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.252', vote=-1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.251', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.250', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.247', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.246', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.245', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.244', vote=1, created=NOW();
insert into votes set quote_id=3, ip_addr='255.255.255.243', vote=1, created=NOW();

select sum(vote) from votes where quote_id=3;


insert into votes set quote_id=4, ip_addr='255.255.255.255', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.254', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.253', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.252', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.251', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.250', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.247', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.246', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.245', vote=-1, created=NOW();
insert into votes set quote_id=4, ip_addr='255.255.255.244', vote=-1, created=NOW();

select sum(vote) from votes where quote_id=4;
