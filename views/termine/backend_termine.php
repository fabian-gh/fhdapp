<?php ob_start();

    //header einbinden
    require_once '../../layout/backend/header.php';

    //controller einbinden und instanziieren
    require_once '../../controllers/termineController.php';
    $appointmentController = new AppointmentController();

    //semester insert / update
    if(isset($_POST['saveSemester']))
    {
        $appointmentController->saveSemester($_POST);
    }

    //semester entfernen
    if(isset($_POST['removeSemester']))
    {
        $appointmentController->removeSemester($_POST);
    }

    //termin insert / update
    if(isset($_POST['saveAppointment']))
    {
        $appointmentController->saveAppointment($_POST);
    }

    //termin entfernen
    if(isset($_POST['removeAppointment']))
    {
        $appointmentController->removeAppointment($_POST);
    }

?>

<!-- link aktivieren -->
<script type="text/javascript">$('#liAppointments').attr('class', 'active');</script>

<!-- funktionen zum überprüfen der felder einbinden -->
<script type="text/javascript" src="../../sources/customjs/termine.js"></script>

<h2>Termine</h2>

<?php

    $departments = $appointmentController->getDepartments();
    echo "<select id='dropdownDepartment' onchange=\"window.location = '../../views/termine/backend_termine.php?dept=' + this.value;\">";
        if($departments != null)
            foreach($departments as $dept)
                echo "<option value=\"{$dept['id']}\">{$dept['name']}</option>";
    echo "</select>";

    //falls department gesetzt, in dropdown auswählen
    if(isset($_GET['dept']))
    {
        echo "<script type='text/javascript'>
        $('#dropdownDepartment').val({$_GET['dept']});
        </script>";
    }
    //ansonsten weiterleiten
    else
    {
        header("Location: ../../views/termine/backend_termine.php?dept=1");
    }

    //alle semester mit ihren terminen für ein fachbereich auslesen
    $semestersWithAppointments = $appointmentController->semestersWithAppointments($_GET['dept']);

    //semester blöcke erstellen
    for($i = 0; $i < count($semestersWithAppointments); $i++)
    {
        $id = $semestersWithAppointments[$i]->id;
        $name = $semestersWithAppointments[$i]->name;
        $from = substr($name, 2, 4);
        $summer = (substr($name, 0, 1) == 'S') ? "checked='checked'" : "";
        $winter = (substr($name, 0, 1) == 'W') ? "checked='checked'" : "";

        echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr><th>ID</th><th>Startjahr</th><th colspan='5'>Sommer-/Wintersemester</th><th>Optionen</th></tr>
            
            <form action='' method='post'>
            <input type='hidden' name='id' value='$id'/>
            <tr><td>$id</td><td><input type='text' name='from' value='$from' onclick='this.focus()' onblur=\"checkYear(this);\"/></td><td colspan='5'><input type='radio' name='type' value='summer' $summer/> Sommer <input type='radio' name='type' value='winter' $winter/> Winter</td><td><input name='saveSemester' type='submit' value='Speichern' onclick=\"return confirm('Die Änderungen des Semesters mit der ID $id werden gespeichert.')\" /><input name='removeSemester' type='submit' value='Entfernen' onclick=\"return confirm('Das Semester mit der ID $id und alle zugehörigen Termine werden entfernt.')\"/></td></tr>
            </form>";
        
            //termine in block einfügen
            echo "<tr><th>ID</th><th>Name</th><th>Startdatum</th><th>Enddatum</th><th>I</th><th>E</th><th>S</th><th>Optionen</th></tr>";
            $temp = $semestersWithAppointments[$i]->appointments;
            if($temp != null)
                foreach($temp as $appointment)
                {
                    $date_from = $appointmentController->sqlToDate($appointment['date_from']);
                    $date_to = $appointmentController->sqlToDate($appointment['date_to']);
                    $interested = ($appointment['interested'] == true) ? "checked='checked'" : "";
                    $freshman = ($appointment['freshman'] == true) ? "checked='checked'" : "";
                    $student = ($appointment['student'] == true) ? "checked='checked'" : "";

                    echo "<form action='' method='post'>
                        <input type='hidden' name='appointment' value='{$appointment['id']}'/>
                        <input type='hidden' name='semester' value='$id'/>
                        <tr><td>{$appointment['id']}</td><td><input type='text' name='name' value='{$appointment['name']}' onclick='this.focus()' onblur=\"checkName(this);\"/></td><td><input type='text' name='date_from' value='$date_from' onclick='this.focus()' onblur=\"checkDate(this);\"/></td><td><input type='text' name='date_to' value='$date_to' onclick='this.focus()' onblur=\"checkDate(this);\"/></td><td><input type='checkbox' name='interested' value='true' $interested /></td><td><input type='checkbox' name='freshman' value='true' $freshman /></td><td><input type='checkbox' name='student' value='true' $student /></td><td><input name='saveAppointment' type='submit' value='Speichern' onclick=\"return confirm('Die Änderungen im Termin mit der ID {$appointment['id']} werden gespeichert.')\"/><input name='removeAppointment' type='submit' value='Entfernen' onclick=\"return confirm('Der Termin mit der ID {$appointment['id']} wird entfernt.')\"/></td></tr>
                    </form>";
                }

            //form zum termin hinzufügen
            echo "<form action='' method='post'>
                <input type='hidden' name='semester' value='$id'/>
                <tr class='alt'><td></td><td><input type='text' name='name' placeholder='Terminname' onclick='this.focus()' onblur=\"checkName(this);\"/></td><td><input type='text' name='date_from' placeholder='T.M.JJJJ' onclick='this.focus()' onblur=\"checkDate(this);\"/></td><td><input type='text' name='date_to' placeholder='T.M.JJJJ' onclick='this.focus()' onblur=\"checkDate(this);\"/></td><td><input type='checkbox' name='interested' value='true' /></td><td><input type='checkbox' name='freshman' value='true' /></td><td><input type='checkbox' name='student' value='true' /></td><td><input name='saveAppointment' type='submit' value='Hinzufügen'/><input type='reset' value='Felder zurücksetzen'/></td></tr>
            </form>
        </table>";
    }

    //form zum semester hinzufügen
    echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr><th>ID</th><th>Startjahr</th><th colspan='5'>Sommer-/Wintersemester</th><th>Optionen</th></tr>

            <form action='' method='post'>
            <input type='hidden' name='dept' value='{$_GET['dept']}'/>
            <tr class='alt'><td></td><td colspan='5'><input type='text' name='from' placeholder='JJJJ' onclick='this.focus()' onblur=\"checkYear(this);\"/></td><td><input type='radio' name='type' value='summer' checked='checked'/> Sommer <input type='radio' name='type' value='winter'/> Winter</td><td><input name='saveSemester' type='submit' value='Hinzufügen'/><input type='reset' value='Felder zurücksetzen'/></td></tr>
            </form>
        </table>";

    //footer einbinden
    require_once '../../layout/backend/footer.php';
    ob_flush();

?>