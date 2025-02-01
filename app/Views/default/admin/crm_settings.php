<style>
  .collapse-toggle::before {
    content: "+";
    margin-right: 5px;
  }

  .collapse-toggle[aria-expanded="true"]::before {
    content: "-";
  }
</style>


</head>

<body class="bg-light text-dark">

  <?= view('default/crm/navbar.php') ?>



  <div class=" container col-11 text-dark bg-white mt-3 border pl-0 pr-0">

    <ul class="breadcrumb rounded-0 text-dark pb-2 pt-2">
      <li class="breadcrumb-item"><a href="<?= base_url('crm') ?>"><?= lang('Crm.crmTitle') ?></a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><?= lang('Crm.controlPanel') ?></a></li>
      <li class="breadcrumb-item active"><?= lang('Crm.crmSettings') ?></li>
    </ul>

    <div class="row pl-3 pr-3 pb-3">

      <div class="container col-md-10 offset-md-1 pt-4 pb-4">


        <div id="accordion" class="rounded-0">
          <div class="card rounded-0">
            <div class="card-header">
              <a class="card-link" data-toggle="collapse" href="#collapseOne">
                <h6><?= lang('Crm.crmSettings') ?></h6>
              </a>
            </div>
            <div id="collapseOne" class="collapse ">
              <div class="card-body">


                <div class="col-sm-12 text-left pb-2">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input settings-checkbox" id="switch" name="1" data-setting-id="1" <?= ($allowToSeeOtherUsersRecords == 1 ? 'checked' : '') ?>>
                    <label class="custom-control-label" for="switch"> <?= lang('Crm.allowToSeeOtherUsersRecords') ?></label>
                  </div>
                </div>



              </div>
            </div>
          </div>
          <div class="card rounded-0">
            <div class="card-header">
              <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                <h6><?= lang('Crm.language') ?></h6>
              </a>
            </div>
            <div id="collapseTwo" class="collapse">
              <div class="card-body">

                <div class="form-group pb-4">
                  <label for="lang"><?= lang('Crm.language') ?>:</label>
                  <select class="form-control" id="lang" name="lang" data-setting-id="2">
                    <?php
                    if (is_array($supportedLocales)) {
                      foreach ($supportedLocales as $key => $value) {
                        echo ' <option value="' . $key . '"' . ($value == $crmLang ? " selected" : "") . '>' . lang('Crm.supportedLanguages')[$value] . '</option>' . PHP_EOL;
                      }
                    }
                    ?>

                  </select>


                </div>


              </div>
            </div>
          </div>
          <div class="card rounded-0">
            <div class="card-header">
              <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                <h6><?= lang('Crm.currencies') ?></h6>
              </a>
            </div>
            <div id="collapseThree" class="collapse">
              <div class="card-body">
                <div class="mb-4">

                  <div class=" pb-4">

                    <div class="col-12 ">
                      <ul class="list-group" id="currencies">
                      </ul>
                    </div>

                  </div>


                  <div class="pt-1">
                    <a class="collapse-toggle text-decoration-none" data-toggle="collapse" data-target="#addcurrency" aria-expanded="false" aria-controls="addcurrency"><?= lang('Crm.addCurrency') ?></a>

                    <div class="collapse pt-4 pb-4" id="addcurrency">
                      <form data-setting-id="4" id="addcurrencyform">

                        <div class="form-group">
                          <label for="currencyname" class="small"><?= lang('Crm.currencyName') ?> *</label>
                          <input type="text" class="form-control" name="currencyname" id="currencyname" maxlength="255" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                          <label for="currencycode" class="small"><?= lang('Crm.currencyCode') ?> *</label>
                          <input type="text" class="form-control" name="currencycode" id="currencycode" maxlength="3" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                          <label for="currencysign" class="small"><?= lang('Crm.currencySign') ?> </label>
                          <input type="text" class="form-control" name="currencysign" id="currencysign" maxlength="1">
                        </div>
                        <div class="pt-2 pb-4">
                          <button type="submit" id="savecurrency" class="btn btn-info btn-sm float-right" tabindex="-1"><?= lang('Crm.save') ?> </button>
                        </div>

                        <div id="addcurrencyresponse" class="pt-4 pb-4"></div>
                      </form>
                    </div>

                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>



      </div>

    </div>

  </div>

  <script>
    var updateSettingsUrl = "<?= base_url('ajax/update-crm-settings/') ?>";



    $(document).ready(function() {

      loadCurrencies();

      $('.settings-checkbox').on('click', function() {

        $.ajax({
          type: "GET",
          url: updateSettingsUrl + $(this).data("setting-id"),
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          data: {
            value: +this.checked,
          },
          success: function(data) {}
        });
      });

      $('#lang').on('change', function() {

        $.ajax({
          type: "GET",
          url: updateSettingsUrl + $(this).data("setting-id"),
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          data: {
            value: this.value,
          },
          success: function(data) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url('ajax/check-lang/0') ?>');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send();
            xhr.onload = function() {
              if (xhr.status === 200) {
                location.reload();
              }
            };
          }
        });
      });


      $('#addcurrencyform').submit(function(event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: updateSettingsUrl + $(this).data("setting-id"),
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              loadCurrencies();
              $('#addcurrencyform')[0].reset();
            } else {
              $('#addcurrencyresponse').html('<p class="text text-danger">' + response.message + '</p');
            }
          },
          error: function(xhr, status, error) {
            $('#addcurrencyresponse').html('<p class="text text-danger"> ' + error + '</p>');
          }
        });
      });


      $(document).on('click', '.delcurrency', function(event) {
        event.preventDefault();

        var id = $(this).data('currencyid');
        $(this).closest('.list-group-item').remove();

        $.ajax({
          type: 'GET',
          url: updateSettingsUrl + '5',
          data: {
            id: id
          },
          success: function(response) {
            loadCurrencies();
            console.log(id);
            console.log(response);
          }
        });
      });

      $(document).on('click', '.setdefaultcurrency', function(event) {
        event.preventDefault();
        var id = $(this).data('currencyid');

        $.ajax({
          type: "GET",
          url: updateSettingsUrl + "3",
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          data: {
            id: id,
          },
          success: function(data) {
            loadCurrencies();
          }
        });


      });

    });


    function loadCurrencies() {

      $.ajax({
        url: updateSettingsUrl + '6',
        dataType: 'json',

        success: function(response) {

          var defaultCurrency = response.defaultCurrency;

          $('#currencies').empty();


          $.each(response.currencies, function(index, currencies) {
            var liElements = $('<li class="list-group-item d-flex justify-content-between align-items-center"></li>');
            liElements.append(currencies.currency_name + " (" + currencies.currency_code + ")");
            var spanElements = $('<span class="pull-right"></span>');
            var deleteLink = $('<a class="delcurrency text-danger mr-3" href="#" data-currencyid="' + currencies.id + '"><i class="fas fa-trash"></i></a>');

            if (currencies.id == defaultCurrency) {
              var defLink = $('<a class="ml-4 setdefaultcurrency text-success" href="#" data-currencyid="' + currencies.id + '" ><i class="fas fa-check-circle"></i></a>');
            } else {
              var defLink = $('<a class="ml-4 text-secondary setdefaultcurrency" href="#" data-currencyid="' + currencies.id + '" ><i class="far fa-check-circle"></i></a>');
            }
            spanElements.append(deleteLink);
            spanElements.append(defLink);
            liElements.append(spanElements);

            $('#currencies').append(liElements);

          });


        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }
  </script>