<?php

$button_color = get_option('scheduled_button_color','#56c477');
$light_color = get_option('scheduled_light_color','#c4f2d4');
$dark_color = get_option('scheduled_dark_color','#039146');

?>

#ui-datepicker-div.scheduled_custom_date_picker table.ui-datepicker-calendar tbody td a.ui-state-active,
#ui-datepicker-div.scheduled_custom_date_picker table.ui-datepicker-calendar tbody td a.ui-state-active:hover,
body #scheduled-profile-page input[type=submit].button-primary:hover,
body .scheduled-list-view button.button:hover, body .scheduled-list-view input[type=submit].button-primary:hover,
body div.scheduled-calendar input[type=submit].button-primary:hover,
body .scheduled-modal input[type=submit].button-primary:hover,
body div.scheduled-calendar .bc-head,
body div.scheduled-calendar .bc-head .bc-col,
body div.scheduled-calendar .scheduled-appt-list .timeslot .timeslot-people button:hover,
body #scheduled-profile-page .scheduled-profile-header,
body #scheduled-profile-page .scheduled-tabs li.active a,
body #scheduled-profile-page .scheduled-tabs li.active a:hover,
body #scheduled-profile-page .appt-block .google-cal-button > a:hover,
#ui-datepicker-div.scheduled_custom_date_picker .ui-datepicker-header
{ background:<?php echo $light_color; ?> !important; }

body #scheduled-profile-page input[type=submit].button-primary:hover,
body div.scheduled-calendar input[type=submit].button-primary:hover,
body .scheduled-list-view button.button:hover, body .scheduled-list-view input[type=submit].button-primary:hover,
body .scheduled-modal input[type=submit].button-primary:hover,
body div.scheduled-calendar .bc-head .bc-col,
body div.scheduled-calendar .scheduled-appt-list .timeslot .timeslot-people button:hover,
body #scheduled-profile-page .scheduled-profile-header,
body #scheduled-profile-page .appt-block .google-cal-button > a:hover
{ border-color:<?php echo $light_color; ?> !important; }

body div.scheduled-calendar .bc-row.days,
body div.scheduled-calendar .bc-row.days .bc-col,
body .scheduled-calendarSwitcher.calendar,
body #scheduled-profile-page .scheduled-tabs,
#ui-datepicker-div.scheduled_custom_date_picker table.ui-datepicker-calendar thead,
#ui-datepicker-div.scheduled_custom_date_picker table.ui-datepicker-calendar thead th
{ background:<?php echo $dark_color; ?> !important; }

body div.scheduled-calendar .bc-row.days .bc-col,
body #scheduled-profile-page .scheduled-tabs
{ border-color:<?php echo $dark_color; ?> !important; }

#ui-datepicker-div.scheduled_custom_date_picker table.ui-datepicker-calendar tbody td.ui-datepicker-today a,
#ui-datepicker-div.scheduled_custom_date_picker table.ui-datepicker-calendar tbody td.ui-datepicker-today a:hover,
body #scheduled-profile-page input[type=submit].button-primary,
body div.scheduled-calendar input[type=submit].button-primary,
body .scheduled-list-view button.button, body .scheduled-list-view input[type=submit].button-primary,
body .scheduled-list-view button.button, body .scheduled-list-view input[type=submit].button-primary,
body .scheduled-modal input[type=submit].button-primary,
body div.scheduled-calendar .scheduled-appt-list .timeslot .timeslot-people button,
body #scheduled-profile-page .scheduled-profile-appt-list .appt-block.approved .status-block,
body #scheduled-profile-page .appt-block .google-cal-button > a,
body .scheduled-modal p.scheduled-title-bar,
body div.scheduled-calendar .bc-col:hover .date span,
body .scheduled-list-view a.scheduled_list_date_picker_trigger.scheduled-dp-active,
body .scheduled-list-view a.scheduled_list_date_picker_trigger.scheduled-dp-active:hover,
.scheduled-ms-modal .scheduled-book-appt,
body #scheduled-profile-page .scheduled-tabs li a .counter
{ background:<?php echo $button_color; ?>; }

body #scheduled-profile-page input[type=submit].button-primary,
body div.scheduled-calendar input[type=submit].button-primary,
body .scheduled-list-view button.button, body .scheduled-list-view input[type=submit].button-primary,
body .scheduled-list-view button.button, body .scheduled-list-view input[type=submit].button-primary,
body .scheduled-modal input[type=submit].button-primary,
body #scheduled-profile-page .appt-block .google-cal-button > a,
body div.scheduled-calendar .scheduled-appt-list .timeslot .timeslot-people button,
body .scheduled-list-view a.scheduled_list_date_picker_trigger.scheduled-dp-active,
body .scheduled-list-view a.scheduled_list_date_picker_trigger.scheduled-dp-active:hover
{ border-color:<?php echo $button_color; ?>; }

body .scheduled-modal .bm-window p i.fa,
body .scheduled-modal .bm-window a,
body .scheduled-appt-list .scheduled-public-appointment-title,
body .scheduled-modal .bm-window p.appointment-title,
.scheduled-ms-modal.visible:hover .scheduled-book-appt
{ color:<?php echo $button_color; ?>; }

.scheduled-appt-list .timeslot.has-title .scheduled-public-appointment-title { color:inherit; }
