/* js functions for managing the question management view */
var multiAnsLimit = 5;
var qusContainerHtml = $('#qus-container').html();
var addNewQusLink = $('#add-new-qus-link').html();
$(document).ready(function() {
    var qusTypeArr = JSON.parse(qusType);

    /* handle click event of add new task link */
    $(document).on('click', 'a#add-new-qus', function() {
        qusContainerHtml = $('#qus-container').html();
        addNewQusLink = $('#add-new-qus-link').html();
        var count = $(this).attr('count-val');
        var htmlData = '<div class="main-qus">';
        htmlData += '<div class="qus-inputs row">' + questionHtml(count) + '</div>';
        htmlData += '<div class="ans-inputs row">' + answersHtml('1', count) + '</div>';
        /* count value get from count-val attr and sub-count-val would be 0 when add a new question */
        htmlData += '<div class="clearfix"><div class="pull-right"><a class="add-new-sub-qus" count-val="' + count + '" title="Add Sub Question" sub-count-val="0" href="javascript:void(0);"><i class="fa fa-plus"> </i>Add Sub Question</a></div></div>';
        htmlData += '</div>';
        $('div#qus-container').append(htmlData);
        count = parseInt(count) + 1;
        $(this).attr('count-val', count); /* increase the count when clicked on add new task */
    });

    /* handle click event of add new task link */
    $(document).on('click', 'a.add-new-sub-qus', function() {
        qusContainerHtml = $('#qus-container').html();
        addNewQusLink = $('#add-new-qus-link').html();
        var countVal = $(this).attr('count-val');
        var subCountVal = $(this).attr('sub-count-val');
        var htmlData = '<div class="sub-qus">';
        htmlData += '<div class="qus-inputs row">' + questionHtml(countVal, subCountVal) + '</div>';
        htmlData += '<div class="ans-inputs row">' + answersHtml('1', countVal, subCountVal) + '</div>';
        htmlData += '</div>';
        $(htmlData).insertBefore($(this).closest('.main-qus').find('.clearfix'));
        subCountVal = parseInt(subCountVal) + 1;
        $(this).attr('sub-count-val', subCountVal); /* increase the count when clicked on add new task */
    });

    /* handle click event of change the select option of answer types */
    $(document).on('change', 'select.ans-choice', function() {
        qusContainerHtml = $('#qus-container').html();
        addNewQusLink = $('#add-new-qus-link').html();
        var answerTypeVal = $(this, ':selected').val();
        var count = $(this).attr('count-val');
        var subCount = $(this).attr('sub-count-val');
        var htmlData = answersHtml(answerTypeVal, count, subCount);
        $(this).closest('div.qus-inputs').next('.ans-inputs').html(htmlData);
        if (answerTypeVal == '3') {
            /* if main question is multiple line answer then no need to add further sub questions */
            if ($(this).closest('.qus-inputs').parent().attr('class') == 'main-qus') {
                $(this).closest('.qus-inputs').siblings('.sub-qus').remove();
            }/* else if selected sub question is multiple line answer then no need to add further sub questions */
            else if ($(this).closest('.qus-inputs').parent().attr('class') == 'sub-qus') {
                $(this).closest('.qus-inputs').parent('.sub-qus').siblings('.sub-qus').remove();
            }
            $('.add-new-sub-qus').hide();
        } else {
            $('.add-new-sub-qus').show();
        }
    });

    /* handle form submit event */
    $("#qus-detail").on("submit", function(event) {
        event.preventDefault();
        $("input").attr('data-parsley-required', 'true').parsley();
        $('#qus-detail').parsley({
            errorsWrapper: '<span></span>',
            errorTemplate: '<span></span>'
        });

        /* check if no question added */
        if ($(this).find('.qus-input-text').length > 0) {
            if ($('#qus-detail').parsley().validate() != false) {
                var formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success == 1) {
                            $('#qus-container').html('');
                            $('#add-new-qus').attr('count-val', 0);
                            showAlertMessage('Data updated successfully', 'alert-success');
                        } else {
                            showAlertMessage('Something Went Wrong', 'alert-danger');
                        }
                    },
                    error: function() {
                        showAlertMessage('Something Went Wrong', 'alert-danger');
                    }
                });
            }
        } else {
            showAlertMessage('Please add atlease one question', 'alert-danger');
        }
    });

    /* function to manage question div elements data */
    function questionHtml(count, subCount) {
        var html = '', id = '', type = '', typeVal = '';
        var nameVal = '[' + count + ']';
        var attr = 'count-val="' + count + '"';
        if (typeof subCount != 'undefined' && subCount != 'undefined' && subCount != '') {
            nameVal = '[' + count + '_sub_qus][' + subCount + ']';
            attr = 'count-val="' + count + '" sub-count-val="' + subCount + '"';
        }
        html += '<div class="form-group col-md-8"><input class="qus-input-text form-control" name="qus' + nameVal + '" value=""/></div>';
        html += '<div class="form-group col-md-4"><div class="input-group"><div class="input-group-addon">A</div><select name="qus_choice' + nameVal + '" class="ans-choice form-control" ' + attr + '>';
        if (typeof qusTypeArr != 'undefined' && qusTypeArr.length > 0) {
            $(qusTypeArr).each(function(index, value) {
                id = typeof value.id != 'undefined' ? value.id : '';
                typeVal = typeof value.type_value != 'undefined' ? value.type_value : '';
                if (typeVal != '' && id != '')
                    html += '<option value="' + id + '">' + typeVal + '</option>';
            });
        } else {
            html += '<option value="1">Single Choice</option>'; /* only for handling default case if type is not defined */
        }
        html += '</select></div></div>';
        return html;
    }

    /* function to manage answer div elements data */
    function answersHtml(selectedId, count, subCount) {
        var nameVal = '[' + count + '][]';
        if (typeof subCount != 'undefined' && subCount != 'undefined' && subCount != '') {
            nameVal = '[' + count + '_sub_qus][' + subCount + '][]';
        }
        var html = '<div class="form-group col-md-8">';
        switch (selectedId) {
            case '1': /* case for single input box */
                html += '<input class="form-control" name="ans' + nameVal + '" value=""/>';
                break;
            case '2': /* case for Multiple input box */
                for (var i = 0; i < multiAnsLimit; i++)
                    html += '<input class="form-control" name="ans' + nameVal + '" value=""/>';
                break;
            case '3': /* case for Multiline input box or textarea */
                html += '<textarea class="form-control" name="ans' + nameVal + '" value=""></textarea>';
                break;
        }
        html += '</div>';
        return html;
    }

    /* manage cancel functionality on click event of cancel link */
    $('#cancel').click(function() {
        $('#qus-container').html(qusContainerHtml);
        $('#add-new-qus-link').html(addNewQusLink);
    });

    /* display alert message based on classname */
    function showAlertMessage(msg, className) {
        var htmlData = '<div class="alert ' + className + '">';
        htmlData += '<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>';
        htmlData += msg;
        htmlData += '</div>';
        $('#alert-message').html(htmlData);
        $('html, body').animate({scrollTop: 0}, 200);
    }
});