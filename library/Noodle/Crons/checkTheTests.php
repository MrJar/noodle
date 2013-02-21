<?php

class Noodle_Crons_checkTheTests {
    
    public function checkthetests() {
        $tests = Application_Model_TestySprawdzoneTable::getInstance()->getUncheckedTests();
        
        foreach ($tests as $test) {
            // bierzemy zadania do testu
            $tasksFromTest = Application_Model_TestyHas_ZadaniaTable::getInstance()->findOneByTesty_idTesty($test->idTesty);
            foreach ($tasksFromTest as $taskFromTest) {
                $taskFromRozwiazaniaForUserId = Application_Model_RozwiazanieZadaniaTable::getInstance()->findOneByIdzadaniaIdUser($taskFromTest->Zadania_idZadania, $test->Uzytkownicy_idUzytkownicy);
                $taskFromZadania = Application_Model_ZadaniaTable::getInstance()->findOneByIdZadania($taskFromTest->Zadania_idZadania);
                
                $ideone = new Noodle_Ideone_Api();
                
                //$sourceCode = "#include <stdio.h>\nint main(void) { int x; for(; scanf(\"%d\",&x) > 0 && x != 42; printf(\"%d\", x)); return 0; }";
                $sourceCode = $taskFromRozwiazaniaForUserId->rozwiazanie;
                $language = Noodle_Ideone_Api::LANGUAGE_ID_C; // tylko C
                //$input = '1 2 10 42 11';
                $input = $taskFromZadania->danetestowe;
                $run = true;
                $private = 'private';

                $return = $ideone->createSubmission($sourceCode, $language, $input, $run, $private);
                if ($return['error'] != 'OK') {
                    continue;
                }
                
                if ($return['error'] == 'OK') {
                    $return = $ideone->getSubmissionStatus($return['link']);
                }
                
                if ($return['result'] == Noodle_Ideone_Api::RESULT_STATUS) { // success – everything went ok
                    $taskFromRozwiazaniaForUserId->zdobyte_pkt = $taskFromZadania->punkty;
                } else {
                    $taskFromRozwiazaniaForUserId->zdobyte_pkt = 0;
                }
                $taskFromRozwiazaniaForUserId->save();
            }
            
            // liczenie pkt
            $suma = 0;
            foreach ($tasksFromTest as $taskFromTest) {
                $taskFromRozwiazaniaForUserId = Application_Model_RozwiazanieZadaniaTable::getInstance()->findOneByIdzadaniaIdUser($taskFromTest->Zadania_idZadania, $test->Uzytkownicy_idUzytkownicy);
                $suma += $taskFromRozwiazaniaForUserId->zdobyte_pkt;
            }
            
            $testSprawdzony = Application_Model_TestySprawdzoneTable::getInstance()->findOneByIdTesty($test->idTesty);
            $testSprawdzony->zdobyte_punkty = $suma;
            $testSprawdzony->save();
        }
    }
    
}