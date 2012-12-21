<?php session_start();

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

<select id="dropdownDepartment" onchange="window.location = '../../views/termine/backend_termine.php?dept=' + this.value;">
    <option value="1">Architektur</option>
    <option value="2">Design</option>
    <option value="3">Elektrotechnik</option>
    <option value="4">Maschinenbau</option>
    <option value="5">Medien</option>
    <option value="6">Sozial- und Kulturwissenschaften</option>
    <option value="7">Wirtschaft</option>
</select>

<?php

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
        //name + tabellenkopf
        $id = $semestersWithAppointments[$i]->id;
        $name = $semestersWithAppointments[$i]->name;
        $from = substr($name, 2, 4);
        $summer = (substr($name, 0, 1) == 'S') ? "checked='checked'" : "";
        $winter = (substr($name, 0, 1) == 'W') ? "checked='checked'" : "";

        echo "<form action='' method='post'>
            <input type='hidden' name='id' value='$id'/>
            <table width='100%' border='0' cellpadding='0' cellspacing='0'>
                <tr><th>ID</th><th>Startjahr</th><th colspan='5'>Sommer-/Wintersemester</th><th>Optionen</th></tr>
                <tr><td>$id</td><td><input type='text' name='from' value='$from' onchange=\"checkYear(this);\"/></td><td colspan='5'><input type='radio' name='type' value='summer' $summer/> Sommer <input type='radio' name='type' value='winter' $winter/> Winter<td><input name='saveSemester' type='submit' value='Speichern' onclick=\"return confirm('Möchten Sie die Änderungen speichern?')\" /><input name='removeSemester' type='submit' value='Entfernen' onclick=\"return confirm('Möchten Sie das Semester und alle zugehörigen Termine entfernen?')\"/></td></tr>";
            
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
                            <tr><td>{$appointment['id']}</td><td><input type='text' name='name' value='{$appointment['name']}' onchange=\"checkName(this);\"/></td><td><input type='text' name='date_from' value='$date_from' onchange=\"checkDate(this);\"/></td><td><input type='text' name='date_to' value='$date_to' onchange=\"checkDate(this);\"/></td><td><input type='checkbox' name='interested' value='true' $interested /></td><td><input type='checkbox' name='freshman' value='true' $freshman /></td><td><input type='checkbox' name='student' value='true' $student /></td><td><input name='saveAppointment' type='submit' value='Speichern' onclick=\"return confirm('Möchten Sie die Änderungen speichern?')\"/><input name='removeAppointment' type='submit' value='Entfernen' onclick=\"return confirm('Möchten Sie den Termin entfernen?')\"/></td></tr>
                        </form>";
                    }

                //form zum termin hinzufügen
                echo "<form action='' method='post'>
                    <input type='hidden' name='semester' value='$id'/>
                    <tr><td></td><td><input type='text' name='name' value='Terminname' onchange=\"checkName(this);\"/></td><td><input type='text' name='date_from' value='T.M.JJJJ' onchange=\"checkDate(this);\"/></td><td><input type='text' name='date_to' value='T.M.JJJJ' onchange=\"checkDate(this);\"/></td><td><input type='checkbox' name='interested' value='true' /></td><td><input type='checkbox' name='freshman' value='true' /></td><td><input type='checkbox' name='student' value='true' /></td><td><input name='saveAppointment' type='submit' value='Hinzufügen'/><input type='reset' value='Felder zurücksetzen'/></td></tr></form>
                </form>
            </table></form>";
    }

    //form zum semester hinzufügen
    echo "<form action='' method='post'>
        <input type='hidden' name='dept' value='{$_GET['dept']}'/>
        <table width='100%' border='0' cellpadding='0' cellspacing='0'>
            <tr><th>ID</th><th>Startjahr</th><th colspan='5'>Sommer-/Wintersemester</th><th>Optionen</th></tr>
            <tr><td></td><td colspan='5'><input type='text' name='from' value='JJJJ' onchange=\"checkYear(this);\"/></td><td><input type='radio' name='type' value='summer' checked='checked'/> Sommer <input type='radio' name='type' value='winter'/> Winter</td><td><input name='saveSemester' type='submit' value='Hinzufügen'/><input type='reset' value='Felder zurücksetzen'/></td></tr>
        </table>
    </form>";

    //footer einbinden
    require_once '../../layout/backend/footer.php';

?>

        