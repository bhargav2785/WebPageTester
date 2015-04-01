show create table webpagetest.tests;
select * from webpagetest.tests;
select * from webpagetest.tests where test_id = '150331_R6_d3e3312e1e4767f3f1b2e2c106ac2cd0';
-- delete from webpagetest.tests where id > 0;


-- --------------------------------------------------------------------------------------------------------------------------------------


select * from webpagetest.tests where processed = 0;
select * from webpagetest.summary where testid = '150331_XH_02dbd1790ac78fc76032c0641398ad24';


-- --------------------------------------------------------------------------------------------------------------------------------------


show create table webpagetest.summary;
select * from webpagetest.summary;
select count(*) from webpagetest.summary;
-- delete from webpagetest.summary where id > 0;


-- --------------------------------------------------------------------------------------------------------------------------------------


show create table webpagetest.requests;
select * from webpagetest.requests order by 1 desc;
select count(*) from webpagetest.requests;
-- delete from webpagetest.requests where id > 0;