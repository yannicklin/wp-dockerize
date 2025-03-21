acf.add_action('ready append', function ($) {
  let labelFieldId = 'field_64a272c6a2328';
  let labelInput = $.find(`.acf-field[data-key="${labelFieldId}"] input`);
  let labelElement = $.find('.acf-field-message label').first();

  let initialLabel = labelElement.text();

  if(labelInput.length && labelElement.length && labelInput.val()) {
    labelElement.text(initialLabel + ' - ' + labelInput.val());
  }

  labelInput.on('keyup', function () {
    labelElement.text(initialLabel + ' - ' + labelInput.val());
  });
});
