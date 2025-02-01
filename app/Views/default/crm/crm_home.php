</head>

<body class="bg-light text-dark">


  <?= view('default/crm/navbar.php') ?>


  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <div class="row pl-3 pr-3 pb-3 ">


      <div class="col-12">
        <?= view('default/crm/crm_message_box.php') ?>
      </div>


      <?= view('default/crm/crm_home_planned_future_calls.php') ?>

      <?= view('default/crm/crm_home_planned_future_meetings.php') ?>

      <?= view('default/crm/crm_home_active_tasks.php') ?>

      <?= view('default/crm/crm_home_active_opportunities.php') ?>

      <?= view_cell('\App\Controllers\crm\Viewcells::homeNearestPersonsBirthdaysList', ['userId' => session()->get('userId')]) ?>


    </div>
  </div>

  <script>
    var getHomeContentUrl = "<?= base_url('ajax/get-home-content-lists/') ?>";
    var callsOffset = 0;
    var meetingsOffset = 0;
    var tasksOffset = 0;
    var opportunityOffset = 0;

    var callUrlBase = "<?= base_url('crm/activities/call/') ?>";
    var meetingUrlBase = "<?= base_url('crm/activities/meeting/') ?>";
    var tasksUrlBase = "<?= base_url('crm/activities/task/') ?>";
    var opportunitiesUrlBase = "<?= base_url('crm/opportunity/') ?>";

    var tasksStatus = <?php echo json_encode(lang('Crm.taskStatusList'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>;
    var opportunitiesStage = <?php echo json_encode(lang('Crm.opportunityStageList'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>;



    $(document).ready(function() {

      loadHomePlannedCalls();
      loadHomePlannedMeetings();
      loadHomeActiveTasks();
      loadHomeActiveOpportunities();


      $('#loadMorePlannedCalls').on('click', function() {loadHomePlannedCalls();});
      $('#loadMorePlannedMeetings').on('click', function() {loadHomePlannedMeetings();})
      $('#loadMoreActiveTasks').on('click', function() {loadHomeActiveTasks();})
      $('#loadMoreActiveOpportunities').on('click', function() {loadHomeActiveOpportunities();})


    });

    function loadHomePlannedCalls() {

      $.ajax({
        url: getHomeContentUrl + 0,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        method: "GET",
        data: {
          offset: callsOffset
        },
        dataType: "json",
        success: function(response) {
          if (response.list.length > 0) {
            response.list.forEach(li => {
              $('#homePlannedFutureCallsList').append(
                `<div class="pb-1">
                  <span> <a  class="font-weight-normal" href="${callUrlBase}${li.id}">${li.title}</a></span><br>
                  <span class="text-muted">${formatDateAndTime(li.start_date)}</span>
                </div>`);
            });

            callsOffset += response.list.length;

            if (callsOffset >= response.total) {
              $('#loadMorePlannedCalls').addClass("d-none");
            } else {
              $('#loadMorePlannedCalls').removeClass("d-none");
            }
          } else {
            $('#loadMorePlannedCalls').addClass("d-none");
          }
        }
      });
    }

    function loadHomePlannedMeetings() {

      $.ajax({
        url: getHomeContentUrl + 1,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        method: "GET",
        data: {
          offset: meetingsOffset
        },
        dataType: "json",
        success: function(response) {
          if (response.list.length > 0) {

            response.list.forEach(li => {
              $('#homePlannedFutureMeetingsList').append(
                `<div class="pb-1">
                  <span> <a  class="font-weight-normal" href="${meetingUrlBase}${li.id}">${li.title}</a></span><br>
                  <span class="text-muted">${formatDateAndTime(li.start_date)}</span>
                </div>`);
            });

            meetingsOffset += response.list.length;

            if (meetingsOffset >= response.total) {
              $('#loadMorePlannedMeetings').addClass("d-none");
            } else {
              $('#loadMorePlannedMeetings').removeClass("d-none");
            }
          } else {
            $('#loadMorePlannedMeetings').addClass("d-none");
          }
        }
      });
    }


    function loadHomeActiveTasks() {

      $.ajax({
        url: getHomeContentUrl + 2,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        method: "GET",
        data: {
          offset: tasksOffset
        },
        dataType: "json",
        success: function(response) {
          if (response.list.length > 0) {

            response.list.forEach(li => {
              $('#homeAciveTasksList').append(
                `<div class="pb-1">
                <span> <a  class="font-weight-normal" href="${tasksUrlBase}${li.id}">${li.title}</a></span><br>
                <span class="text-muted ">${tasksStatus[li.status]}</span>
                </div>`);
            });

            tasksOffset += response.list.length;

            if (tasksOffset >= response.total) {
              $('#loadMoreActiveTasks').addClass("d-none");
            } else {
              $('#loadMoreActiveTasks').removeClass("d-none");
            }
          } else {
            $('#loadMoreActiveTasks').addClass("d-none");
          }
        }
      });
    }


    function loadHomeActiveOpportunities() {

      $.ajax({
        url: getHomeContentUrl + 3,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        method: "GET",
        data: {
          offset: opportunityOffset
        },
        dataType: "json",
        success: function(response) {
          if (response.list.length > 0) {

            response.list.forEach(li => {
              $('#homeActiveOpportunitiesList').append(
                `<div class="pb-1">
          <span> <a  class="font-weight-normal" href="${opportunitiesUrlBase}${li.id}">${li.title}</a></span><br>
          <span class="text-muted ">${opportunitiesStage[li.stage]}</span>
          </div>`);
            });

            opportunityOffset += response.list.length;

            if (opportunityOffset >= response.total) {
              $('#loadMoreActiveOpportunities').addClass("d-none");
            } else {
              $('#loadMoreActiveOpportunities').removeClass("d-none");
            }
          } else {
            $('#loadMoreActiveOpportunitiess').addClass("d-none");
          }
        }
      });
    }


  </script>