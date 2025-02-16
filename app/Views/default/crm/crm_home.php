
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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

      <div class="col-sm-12 col-md-6 col-lg-4 dragparent" id="pmty1"></div>
      <div class="col-sm-12 col-md-6 col-lg-4 dragparent" id="pmty2"></div>
      <div class="col-sm-12 col-md-6 col-lg-4 dragparent" id="pmty3"></div>
      <div class="col-sm-12 col-md-6 col-lg-4 dragparent" id="pmty4"></div>

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



      // Atjauno child div atrašanās vietas no localStorage
      $(".dragchild").each(function() {
        var childId = $(this).attr("id");
        var savedParentId = localStorage.getItem("dragchild-" + childId);
        if (savedParentId && $("#" + savedParentId).length) {
          $("#" + savedParentId).append($(this));
        }
      });

      $(".dragchild").draggable({
        revert: "invalid",
        start: function(event, ui) {
          $(this).data("dragparent", $(this).parent());
          $(this).css("z-index", 1000);
        },
        stop: function(event, ui) {
          $(this).css("z-index", "auto");
        }
      });

      $(".dragparent").droppable({
        accept: ".dragchild",
        drop: function(event, ui) {
          var draggedChild = ui.draggable;
          var previousParent = draggedChild.data("dragparent");

          // Ja jaunajā parent jau ir child, tas atgriežas iepriekšējā parent
          var existingChild = $(this).find(".dragchild");
          if (existingChild.length) {
            previousParent.append(existingChild);
            localStorage.setItem("dragchild-" + existingChild.attr("id"), previousParent.attr("id"));
          }

          // Ievieto child jaunajā parent
          $(this).append(draggedChild);
          draggedChild.css({top: 0, left: 0});

          // Saglabā atrašanās vietu localStorage
          localStorage.setItem("dragchild-" + draggedChild.attr("id"), $(this).attr("id"));
        }
      });

    });



  </script>