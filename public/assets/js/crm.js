var lastCompanyTitle = $("#findCompany").val();
var lastUserName = $("#findUser").val();
var lastParentText = $("#parentText").val();

$(window).keydown(function(event)
{
  if(event.keyCode == 13) {
    event.preventDefault();
    return false;
  }
});

//dzēšanas paziņojuma parādīšana. confirm-message jābūt norādītam kā data atribūtam
$('.delete-link').on('click', function(event) 
{
    event.preventDefault();
    var url = $(this).attr('href');
    var confirmMessage = $(this).data('confirm-message');
    bootbox.confirm({ 
        size: "small",
        message:confirmMessage,
        callback: function(result){ if (result) {window.location.href = url;}}
    });
});

//uzņēmuma meklēšana uzņēmumu sarakstā
$("#findAccount").keyup(function() 
{
  if ( $("#findAccount").val().length < 2){return false;}

   $.ajax({
       type: "GET",
       url: findAccountUrl,
       headers: {'X-Requested-With': 'XMLHttpRequest'},
       data: {
           title: encodeURI($(this).val()),
       },
       success: function(data){
           $("#resultAccount").html(data);
       }
   });

});

$("#findAccount").focusout(function () 
{
   $('#findAccount').val('');
   $("#resultAccount").html('');
});



//personas meklēšana personu sarakstā
  $("#findContact").keyup(function() {
      if ($("#findContact").val().length < 3) {
          $("#resultContact").html('');
          return false;
      }

      $.ajax({
          type: "GET",
          url: findContactUrl,
          headers: {
              'X-Requested-With': 'XMLHttpRequest'
          },
          data: {
              person: encodeURI($(this).val()),
          },
          success: function(data) {
              $("#resultContact").html(data);
          }
      });

  });


$("#findContact").focusout(function() 
{
  $('#findContact').val('');
  $("#resultContact").html('');
});


$("#findUser").keyup(function () 
{
  $.ajax({
    type: "GET",
    url: findUserUrl,
    headers: { "X-Requested-With": "XMLHttpRequest" },
    data: {
      username: encodeURI($(this).val()),
    },
    success: function (data) {
      $("#resultUser").html(data);
    },
  });
});

//uzņēmuma meklēšana personas pievienošanā vai labošanā
$("#findCompany").keyup(function () 
{
  $.ajax({
    type: "GET",
    url: findCompanyUrl,
    headers: { "X-Requested-With": "XMLHttpRequest" },
    data: {
      title: encodeURI($(this).val()),
    },
    success: function (data) {
      $("#resultCompany").html(data);
    },
  });
});

//uzņēmuma meklēšanā personas pievienošanā vai labošanā
function removeCompany() 
{
  $("#companyId").val("");
  $("#findCompany").val("");
  $("#resultCompany").html("");

}

$("#findCompany").focusout(function () 
{
  if (!$("#companyId").val()) {
    $(this).val("");
  } else {
    $(this).val(lastCompanyTitle);
    $("#resultCompany").html("");
  }
});


//interesenta meklēšana interesentu sarakstā
$("#findLead").keyup(function() 
{
  if ( $("#findLead").val().length < 2){return false;}

   $.ajax({
       type: "GET",
       url: findLeadUrl,
       headers: {'X-Requested-With': 'XMLHttpRequest'},
       data: {
           lead: encodeURI($(this).val()),
       },
       success: function(data){
           $("#resultLead").html(data);
       }
   });

});

$("#findLead").focusout(function () 
{
   $('#findLead').val('');
   $("#resultLead").html('');
});

//iespējas meklēšana interesentu sarakstā
$("#findOpportunity").keyup(function() 
{
  if ( $("#findOpportunity").val().length < 2){return false;}

   $.ajax({
       type: "GET",
       url: findOpportunityUrl,
       headers: {'X-Requested-With': 'XMLHttpRequest'},
       data: {
        opportunity: encodeURI($(this).val()),
       },
       success: function(data){
           $("#resultOpportunity").html(data);
       }
   });

});

$("#findOpportunity").focusout(function () 
{
   $('#findOpportunity').val('');
   $("#resultOpportunity").html('');
});



///tiek izmantots personas pievienošanā un labošanā, lai uzstādītu saistīto uzņēmumu
function updateConnectedCompany(id, title) 
{
  $("#companyId").val(id);
  $("#resultCompany").html("");
  $("#findCompany").val(decodeEntities(title));
  lastCompanyTitle = decodeEntities(title);

  //šī daļa netiek izmantota
  /*
  //$("#contactsListDiv").html("");

  if (typeof getCompanyContactsUrl === 'undefined') {
    return true;
  }

  $.ajax({
    type: "GET",
    url: getCompanyContactsUrl + "/" + id,
    headers: { "X-Requested-With": "XMLHttpRequest" },
    success: function (data) {
      $("#contactsListDiv").html(data);
    },
  });
  */

}






$("#findParent").keyup(function () 
{
  $.ajax({
    type: "GET",
    url: findParentUrl,
    headers: { "X-Requested-With": "XMLHttpRequest" },
    data: { find: encodeURI($(this).val()), type: $("#parentType").val()},
    success: function (data) {
      $("#resultParent").html(data);
    },
  });
});


function removeParent() 
{
  $("#parentId").val("");
  $("#findParent").val("");
  $("#resultParent").html("");
  removeSecondaryParentAccount();
}

function updateParent(id,text,accountId,accountTitle)
{
  $("#parentId").val(id);
  $("#resultParent").html('');
  $("#findParent").val(decodeEntities(text));
  lastParentText = decodeEntities(text);
  if (typeof accountId !== 'undefined' && accountTitle !== 'undefined' && accountTitle.length > 0) 
  {
    $("#secondaryParentaccountId").val(accountId);
    $("#secondaryParentAccount").val(accountTitle);
  }

}

$('#parentType').on('change', function() 
{
  if ($(this).val() === '2') {$(".collapse").collapse('show');} 
  else {$(".collapse").collapse('hide');removeSecondaryParentAccount()}
 
  removeParent() 
});

$("#findParent").focusout(function () 
{
  if (!$("#parentId").val()) {
    $(this).val("");
    $("#resultParent").html("");
  } else {
    $(this).val(lastParentText);
    $("#resultParent").html("");
  }
});

function removeSecondaryParentAccount() {
  $('#secondaryParentAccount').val('');
  $('#secondaryParentaccountId').val('0');
}




function updateAssignedUser(id, name)
{
  $("#userId").val(id);
  $("#findUser").val(name);
  $("#resultUser").html("");
  lastUserName = name;
}

function removeAssignedUser() 
{
  $("#userId").val("");
  $("#findUser").val("");
  $("#resultUser").html("");
}


$("#findCompany").focusout(function () 
{
  if (!$("#companyId").val()) {
    $(this).val("");
  } else {
    $(this).val(lastCompanyTitle);
    $("#resultCompany").html("");
  }
});




$("#findUser").focusout(function () 
{
  if (!$("#userId").val()) {
    $(this).val("");
  } else {
    $(this).val(lastUserName);
    $("#resultUser").html("");
  }
});



document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('historyNotesForm');
  
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      var responseDiv = document.getElementById('historyNoteResponse');
      var formData = new FormData();

      formData.append('note', document.getElementById('historyNote').value);

      fetch(historyNotePostUrl, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            responseDiv.innerHTML = '<p style="color: red;">' + data.message + '</p>';
          }
        })
        .catch(error => {
          responseDiv.innerHTML = '<p style="color: red;">' + error.message + '</p>';
        });
    });
  }
});



function removeFile(id) 
{
  $.ajax({
    type: "GET",
    url: deleteFileUrl + "/" + id,
    headers: { "X-Requested-With": "XMLHttpRequest" },
    success: function (data) {
       $('#fileId'+id).remove();
    },
  });
}

function decodeEntities(encodedString) 
{
  var textArea = document.createElement('textarea');
  textArea.innerHTML = encodedString;
  return textArea.value;
}

function formatDateAndTime(datetime, type = 0) {
  if (!datetime) {
    return "";
  }

  try {
    const parts = datetime.split(/[- :]/);
    const year = parts[0];
    const month = parts[1];
    const day = parts[2];
    const hours = parts[3];
    const minutes = parts[4];

    const formattedMonth = month.padStart(2, '0');
    const formattedDay = day.padStart(2, '0');
    const formattedHours = hours.padStart(2, '0');
    const formattedMinutes = minutes.padStart(2, '0');

    if (type == 0) {
      return `${formattedDay}.${formattedMonth}.${year}. ${formattedHours}:${formattedMinutes}`;
    } else if (type == 1) {
      return `${formattedDay}.${formattedMonth}.${year}.`;
    }

  } catch (error) {
    console.error(error);
    return datetime;
  }
}

/// home screen
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
