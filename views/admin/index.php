<?php
include_once __DIR__ . "/../templates/info-bar.php";
?>
<h1 class="page-name title-plain">Panel de administración</h1>

<h3 class="title-plain">Buscar citas</h3>

<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input type="date" id="date" name="date" value="<?php echo $selectedDate ?>">
        </div>
        <input id="seek-apt" type="submit" value="Buscar" class="button submit seek">
    </form>
</div>

<div class="admin-appointments">


    <ul class="appointment-list">
        <?php
        //gather each 'appointment-service record' by its appoitment id 
        //(the id attribute of the object is the id of the appointment in the appointments table (check the sql query in the controller) )
        //because they are the same appoitnment, only with a different service

        $previousId = null; // Track the previous ID
        $appointmentsHtml = ''; //build the html
        $appointmentTotal = 0; // total price of the appointment
        // debugAndFormat($appointments);
        $totalAppointments = count($appointments); // total number of appointments, (to know the end of the loop and close the last <li>)

        if (!$totalAppointments) echo "<h3 class='title-absolute'>No hay citas para este día</h3>";

        foreach ($appointments as $index => $appointment) :
            //current and next id
            $currentId = $appointment->id;
            $nextId = $appointments[$index + 1]->id ?? null;

            //Check if the current id is different from the last
            if ($appointment->id != $previousId) {

                //if it's NOT the first record, close the last <li>
                if ($previousId !== null) $appointmentsHtml .= "</li>";

                //create a new <li> for a new appointment
                $appointmentsHtml .= "<li class='appointment'>";
                $appointmentsHtml .= "<form action='/api/delete' method='post' >";
                $appointmentsHtml .= "<input type='hidden' name='apt_id' value={$appointment->id}>";
                $appointmentsHtml .= "<input class='delete' type='submit' value='Eliminar'>";
                $appointmentsHtml .= "</form>";

                $appointmentsHtml .= "<p class='appointment_id'>ID: " . $appointment->id . "</p>";
                $appointmentsHtml .= "<p class='appointment_date'>Fecha: " . $appointment->date . "</p>";
                $appointmentsHtml .= "<p class='appointment_time'>Hora: " . $appointment->time . "</p>";
                $appointmentsHtml .= "<p class='appointment_customer'>Cliente: " . $appointment->customer . "</p>";
                $appointmentsHtml .= "<p class='appointment_email'>Correo: " . $appointment->customer_email . "</p>";
                $appointmentsHtml .= "<h4 class='appointment_services'>Servicios:</h4>";
            }

            //add the services to the current <li>
            $appointmentsHtml .= "<p class='appointment_service'>" . $appointment->service . "<span class='price'> $" . $appointment->price . "</span></p>";
            //add the price to the total price
            $appointmentTotal += $appointment->price;

            // If the next appoitnment id is different, then print the total price of that appoitnment
            if ($currentId != $nextId) {
                // echo "<p>print total of this appointment {$appointmentTotal}</p>";
                $appointmentsHtml .= "<p class='appointment_total'> $" . $appointmentTotal .  "</p>";
                //restart the  total price
                $appointmentTotal = 0;
            }

            // update previousId
            $previousId = $appointment->id;

            //check if it's the last iteration
            if (!$nextId)  $appointmentsHtml .= "</li>"; // Close last <li>

        endforeach;
        // print html after the end of the foreach
        echo $appointmentsHtml;
        ?>
    </ul>

</div>

<?php $script = "<script src='/build/js/utils/admin/dateSeeker.min.js'></script>";
?>