SELECT * FROM `Per_Rolle` WHERE roll_hs_fsw = 'fsw';

select * from per_personen p, per_rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw';

select * from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw';

-- ohne having Einschränkung
select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion, r.roll_hs_fsw, r.roll_funk_id, r.roll_istangestellt from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' order by p.pers_name, p.pers_vorname;


select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion, r.roll_hs_fsw, r.roll_funk_id, r.roll_istangestellt from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' and p.pers_id NOT IN (select p.pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name,p.pers_vorname having count(p.pers_name) > 1) order by p.pers_name, p.pers_vorname  ;


-- diese Abfrage scheint die Personen zu zeigen, welche doppelte Rollen besitzen
select p.pers_name, p.pers_vorname, r.roll_fswfunktion, roll_funk_id  from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw'  and p.pers_id in (select r.roll_pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name,p.pers_vorname having count(p.pers_name) > 1)  order by p.pers_name, p.pers_id;


select p.pers_id, p.pers_name, p.pers_vorname from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and p.pers_name = 'Tanner' and roll_hs_fsw = 'fsw' order by p.pers_name, p.pers_vorname;


select * from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and r.roll_pers_id = 525 order by p.pers_name, p.pers_vorname;


select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw'  and p.pers_id in (select r.roll_pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name having count(p.pers_name) > 1)  order by p.pers_name, p.pers_id;


select p.pers_name, p.pers_vorname from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw'  and p.pers_id in (select r.roll_pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name,p.pers_vorname having count(p.pers_name) > 1)  order by p.pers_name, p.pers_id;


select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw'  and p.pers_id in (select p.pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name having count(p.pers_name) > 1)  order by p.pers_name, p.pers_id;


-- Gruppierung pers_id
select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id   and p.pers_id in (select p.pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_id having count(p.pers_id) > 1)  order by p.pers_name, p.pers_id;


-- welche Personen haben doppelte Rollen
select p.pers_name, p.pers_vorname from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name having count(p.pers_name) > 1;

select p.pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_name having count(p.pers_name) > 1;


select p.pers_name, p.pers_vorname from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = 'fsw' group by p.pers_id having count(p.pers_id) > 1;


-- http://www.nachbarnetbasel.ch/


