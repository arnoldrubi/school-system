function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
   document.location = delUrl;
  }
}
function confirmAdd(addSubjectlUrl) {
  if (confirm("Add this subject?")) {
   document.location = addSubjectlUrl;
  }
}
function confirmRestore(RestoreUrl) {
  if (confirm("Do you want to restore this coures?")) {
   document.location = RestoreUrl;
  }
}
function computeGrades(){
	$(this).closest("tr").find(".final-computed-grade").val();
    var prelim = parseInt($(this).closest("tr").find("input[name='prelim[]']").val());
    var midterm = parseInt($(this).closest("tr").find("input[name='midterm[]']").val());
    var semis = parseInt($(this).closest("tr").find("input[name='semis[]']").val());
    var finals = parseInt($(this).closest("tr").find("input[name='finals[]']").val());
    var computed_grades = (prelim + midterm + semis + finals) / 4;
    console.log(computed_grades);
    $(this).closest("tr").find(".final-computed-grade").val(computed_grades);
}
function roundOffGrade(raw_grade,final_grade){

  if (raw_grade >= 1.0 && raw_grade <= 1.12 ) {
    final_grade = 1.0;
  }

  return final_grade;

}

