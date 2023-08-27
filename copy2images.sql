INSERT INTO  images ( patientName ,  apptDate ,  doctorName ,  doctorSpecialty ,  fee ,  reason ,  diagnosis ,  vitalsWeight ,  vitalsBP ) 
SELECT patientName ,  apptDate ,  doctorName ,  doctorSpecialty ,  fee ,  reason ,  diagnosis ,  vitalsWeight ,  vitalsBP  
FROM surgeries
WHERE reason like "%scan%" OR
reason like "%ultra%" OR
reason like "%xray%" OR
reason like "%stress%" OR
reason like "%barium%" OR
reason like "%echo%" OR
reason like "%ct %" OR
reason like "%spiro%" OR
reason like "%perfusion%" OR
reason like "%endoscopy%"
;