$(document).ready(function() {
    $('#bookTableId').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [],
        "paging":true,
        "pagingType": "full_numbers",
        "ajax": "Http/Controllers/BookController.php"
    } );
} );

$('#bookTableId').on('click', 'tbody td', function() {
    
    /** The notes column is on index 6 **/
    if(this.cellIndex == 6){
      var recordId = String(this.parentNode.cells[0].textContent);
      var theInput = document.getElementById(recordId);
      
      if (!theInput) {
          /** Create input element to capture user entry **/
          var bookNote = document.createElement('input');
          bookNote.type = "text";
          bookNote.id = this.parentNode.cells[0].textContent;
          this.appendChild(bookNote);
          if(this.textContent !== "")
            bookNote.value = this.textContent;
          /** Use ESC key to deactivate input box on notes **/
          document.getElementById(recordId).onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                var elem = document.getElementById(String(this.parentNode.parentNode.cells[0].textContent));
                elem.remove();
            }
          }
          
          /** Focus cursor on notes column in anticipation of user entry **/
          document.getElementById(recordId).focus();
      }
    }

})

$('#updateNote').click(function() {
    updateNote();
});

function updateNote(){
    var updateArray = [];
    var arrayIndex = 0;

    $('#bookTableId tr').each(function(){
        var rowId;
        $(this).find('td').each(function(){
            if($(this).index() == 6){
				if ($(this).find('input').length) {
					//input box to capture notes exists, therefore get the id
					$(this).find('input').each(function(){
						rowId = $(this)[0].id;
					});
                    /** User initiated an input entry on this column, so capture in array **/
                    updateArray[arrayIndex] = []
                    updateArray[arrayIndex][0] = rowId;
                    updateArray[arrayIndex][1] = document.getElementById(String(rowId)).value;
                    arrayIndex++;
                    var element = document.getElementById(String(rowId));
                    element.parentNode.removeChild(element);
                }
            }    
            
        })
    })
    
    if(updateArray.length === 0){
        jAlert('No selection made for update on notes', 'Nothing to update');
        return;
    }
    
    $.ajax({
        type: "POST",
        url: "Http/Controllers/BookController.php",
        data: {param:"notes", notes:updateArray},
        success: function(data){
            /** Refresh table with updated values **/
            var table = $('#bookTableId').DataTable();
            table.draw();
            jAlert('Records were updated successfully.', 'Update Successful');
        },
        failure: function(errMsg) {
            //insert failure callback here
        }
  });
}

