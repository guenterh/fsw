http://w3.fsw.uzh.ch/static/zf2/public/index.php/presentation/qarb/show?betreuer[]=straumann&betreuer[]=goltermann&status[]=abgebrochen&status[]=abgeschlossen&typ[]=diss&typ[]=habil


http://w3.fsw.uzh.ch/static/zf2/public/index.php/presentation/qarb/show?betreuer[]=straumann&betreuer[]=goltermann&status[]=abgebrochen&status[]=abgeschlossen&typ[]=diss&typ[]=master


[QarbBetreuer]
;query parameter: betreuer[]
straumann   =   835
sarasin =   101
tanner  =   103
goltermann  =   102
;woitek  =   1015

[QarbTypen]
;query parameter: typ[]
diss    =   Dissertation
habil   =   Habilitation
liz     =   Lizenziatsarbeit
master  =   Masterarbeit

[QarbStatus]
;query parameter: status[]
laufend         =   0
abgeschlossen   =   1
abgebrochen     =   2

[QarbSort]
;query parameter sort
name    =   p.pers_name
abschluss    =   a.qarb_arb_abschlussjahr

Für Vergleiche:
select p.*, a.*,pext.profilURL from Per_Personen p join Per_Rolle r on (p.pers_id = r.roll_pers_id)  join  Qarb_ArbeitenV2 a on (r.roll_id = a.qarb_arb_autor_rollid)  left join fsw_personen_extended pext   on (p.pers_id = pext.pers_id) where  a.qarb_arb_betreuer1_rollid in (91,89,90)  and a.qarb_arb_istabgeschlossen in (1)  and a.qarb_arb_typ in ('Lizentiatsarbeit','Masterarbeit')  order by p.pers_name


select p.*, a.*,pext.profilURL from Per_Personen p join Per_Rolle r on (p.pers_id = r.roll_pers_id)  join  Qarb_ArbeitenV2 a on (r.roll_id = a.qarb_arb_autor_rollid)  left join fsw_personen_extended pext   on (p.pers_id = pext.pers_id) where  a.qarb_arb_betreuer1_rollid in (91,89,90)  and a.qarb_arb_istabgeschlossen in (0)  and a.qarb_arb_typ in ('Lizentiatsarbeit','Masterarbeit')  order by p.pers_name

select p.*, a.*,pext.profilURL from Per_Personen p join Per_Rolle r on (p.pers_id = r.roll_pers_id)  join  Qarb_ArbeitenV2 a on (r.roll_id = a.qarb_arb_autor_rollid)  left join fsw_personen_extended pext   on (p.pers_id = pext.pers_id) where  a.qarb_arb_betreuer1_rollid in (91,89,90)  and a.qarb_arb_istabgeschlossen in (0)  and a.qarb_arb_typ in ('Dissertation')  order by p.pers_name


Abfrage auf der alten Seite
http://www.fsw.uzh.ch/static/getAktivitaeten.php?activity=liz&mitid=0&abgeschlossen=1&sortCriteria=chronologisch

select * from download 
where typ in  ('liz','master')
and abgeschlossen = 1
order by person



