<!DOCTYPE html>
<html>
    <head>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta charset="utf-8">
        <title>Create PDF from View</title>
        <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" /> -->

        <style>
        .footer {
            position: fixed;
            /* left: 0; */
            bottom: 105;
            width: 100%;
            /* text-align: center; */
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding-top: 30px;
            /* border: 1px solid #eee; */
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            /* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table tr {
            margin: 10px 0;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 24px;
            line-height: 24px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(4) {
            text-align: left;
        }
</style>
    </head>

    <body>
        <div class="invoice-box">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <h1 class="text-center">
                                <?php echo html_escape($this->security->xss_clean($this->db->get_where('setting', array('item' => 'system_name'))->row()->content)); ?>
                            </h1>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td><h4 class="text-center">Medical Prescription</h4></td>
                    </tr>
                </tbody>
            </table>
            <?php 
                if ($this->db->get_where('prescription', array('prescription_id' => $prescription_id))->num_rows() > 0):
                $doctor_id = $this->db->get_where('prescription', array('prescription_id' => $prescription_id))->row()->doctor_id;
                $patient_id = $this->db->get_where('prescription', array('prescription_id' => $prescription_id))->row()->patient_id;
            ?>
            <table>
                <tbody>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <p style="font-size: 10px; font-style: bold;">Patient</p>
                            <?php 
                                if ($this->db->get_where('patient', array('patient_id' => $patient_id))->num_rows() > 0)
                                    echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name; 
                                else
                                    echo 'Patient not found.';
                            ?>
                        </td>
                        <td>
                            <p style="font-size: 10px; font-style: bold;">Patient ID</p>
                            <?php 
                                if ($this->db->get_where('patient', array('patient_id' => $patient_id))->num_rows() > 0)
                                    echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->pid; 
                                else
                                    echo 'PID not found.';
                            ?>
                        </td>
                        <td>
                            <p style="font-size: 10px; font-style: bold;">Next Appointment</p>
                            <?php 
                                if ($this->db->get_where('prescription', array('prescription_id' => $prescription_id))->num_rows() > 0)
                                    echo date('d M, Y', $this->db->get_where('prescription', array('prescription_id' => $prescription_id))->row()->next_appointment); 
                                else
                                    echo 'No appointment found.';
                            ?>
                        </td>
                        <td>
                            <p style="font-size: 10px; font-style: bold;">Doctor</p>
                            <?php 
                                if ($this->db->get_where('doctor', array('doctor_id' => $doctor_id))->num_rows() > 0)
                                    echo $this->db->get_where('doctor', array('doctor_id' => $doctor_id))->row()->name; 
                                else
                                    echo 'Doctor not found.';
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>
            <table>
                <tbody>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr style="font-size: bold">
                        <td>#</td>
                        <td>Medicine</td>
                        <td>Dose</td>
                        <td>Medication Time</td>
                    </tr>
                    <tr><td></td></tr>
                    <?php
                    $count = 1;
                    $prescription_details	=	$this->security->xss_clean($this->db->get_where('prescription_details', array('prescription_id' => $prescription_id))->result_array());
                    foreach ($prescription_details as $prescription_detail) :
                    ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                                <?php 
                                    if ($this->db->get_where('medicine', array('medicine_id' => $prescription_detail['medicine_id']))->num_rows() > 0)
                                        echo $this->security->xss_clean($this->db->get_where('medicine', array('medicine_id' => $prescription_detail['medicine_id']))->row()->name); 
                                    else
                                        echo 'Medicine not found.';
                                ?>
                            </td>
                            <td><?php echo $prescription_detail['dose']; ?></td>
                            <td><?php echo $prescription_detail['medication_time']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>        

        <div class="footer">
            <table>
                <tbody>
                    <tr><td><p>Physician's Signature and Stamp (Physician's Signature and Stamp)</p></td></tr>
                    <tr><td>------------------------------------------------------------------------------------------------</td></tr>
                </tbody>
            </table>
            
            <br>
            
            <br>
            <?php echo date("d M, Y", time()); ?>
            <br>
            <br>
            <p class="text-center">
                <?php echo $this->db->get_where('setting', array('item' => 'system_name'))->row()->content . ' ' . $this->db->get_where('setting', array('item' => 'system_address'))->row()->content . ' ' . $this->db->get_where('setting', array('item' => 'system_phone'))->row()->content; ?>
            </p>
        </div>
    </body>
</html>