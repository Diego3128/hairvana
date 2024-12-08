<?php
include_once __DIR__ . "/../templates/info-bar.php";
?>
<h1 class="page-name title-plain">Panel de administración</h1>

<h3 class="title-plain">Buscar citas</h3>

<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input type="date" id="date" name="date">
        </div>
    </form>
</div>

<div class="admin-appointments">
    <!-- gather each 'appointment-service record' by its appoitment id 
     (the id attribute of the object is the id of the appointment in the appoitnments table (check the sql query in the controller) )
     because they are the same appoitnment, only with a different service
    -->
    <ul class="appointment-list">
        <?php
        $previousId = null; // Track the previous ID
        $appointmentsHtml = '';

        // total number of appointments to know the end of the loop
        $totalAppointments = count($appointments);

        foreach ($appointments as $index => $appointment) {
            //Check if the current id is different from the last
            if ($appointment->id != $previousId) {
                //if it's NOT the first record, close the last <li>
                if ($previousId !== null) $appointmentsHtml .= "</li>";

                //create a new <li> for a new appointment
                $appointmentsHtml .= "<li class='appointment'>";
                $appointmentsHtml .= "<p class='appointment_id'>ID: " . $appointment->id . "</p>";
                $appointmentsHtml .= "<p class='appointment_date'>Fecha: " . $appointment->date . "</p>";
                $appointmentsHtml .= "<p class='appointment_time'>Hora: " . $appointment->time . "</p>";
                $appointmentsHtml .= "<p class='appointment_customer'>Cliente: " . $appointment->customer . "</p>";
                $appointmentsHtml .= "<p class='appointment_email'>Correo: " . $appointment->customer_email . "</p>";
                $appointmentsHtml .= "<h4 class='appointment_services'>Servicios:</h4>";
            }

            //add the services to the current <li>
            $appointmentsHtml .= "<p class='appointment_service'>" . $appointment->service . "<span class='price'> $" . $appointment->price . "</span></p>";

            // update previousId
            $previousId = $appointment->id;

            //check if it's the last iteration
            if ($index === $totalAppointments - 1)  $appointmentsHtml .= "</li>"; // Close last <li>

        }
        // print html
        echo $appointmentsHtml;
        ?>
    </ul>

</div>