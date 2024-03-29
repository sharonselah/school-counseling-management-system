
/*const links = document.querySelectorAll('.menu-dashboard ul li a');
const rightDivs = document.querySelectorAll('.right-c, .right-d, .right-e, .right-f, .right-g, .right-h, .right-i, .right-j');

links.forEach((link, index) => {
  link.addEventListener('click', () => {
    hideAll();
    rightDivs[index].classList.remove('hide');
  });
});

function hideAll() {
  rightDivs.forEach((rightDiv) => {
    rightDiv.classList.add('hide');
  });
}*/

        //table 1 searching by name 

        let table = document.getElementById("table"); 
        let rows = table.getElementsByTagName("tr"); 
        let i, td;

        function filterTable(){

            let search = document.getElementById("search");
            let searchValue = search.value.toUpperCase();

            for (i=1; i< rows.length; i++){
                td = rows[i].getElementsByTagName("td")[0];
                //remove whitespace and change to uppercase
                tdValue = td.textContent.trim().toUpperCase();
                //find the index of the first appearance of the search value
                if (tdValue.indexOf(searchValue) > -1){
                        rows[i].style.display= '';
                }else{
                    rows[i].style.display= 'none';
                }

            }
        } 
        search.addEventListener('keyup', filterTable); //fires up when a key is released

        //table 1 sorting 
        let buttonNothing = document.getElementById("Nothing"); 
        let buttonName = document.getElementById ("sortName");
        let buttonSpeciality = document.getElementById("sortSpeciality"); 

       

        function sortName(){
               rows = Array.from(rows).slice(1); //remove the header (1st element)


                rows.sort((a,b) =>{
                    let tdA = a.getElementsByTagName("td")[0].textContent;
                    let tdB = b.getElementsByTagName("td")[0].textContent;

                    return tdA.localeCompare(tdB); 
                });
                
                for (let i=1; i<rows.length; i++){
                    table.appendChild(rows[i]);
                }  
        }

        function sortSpeciality(){
               rows = Array.from(rows).slice(1); 

                rows.sort((a,b) =>{
                    let tdA = a.getElementsByTagName("td")[1].textContent;
                    let tdB = b.getElementsByTagName("td")[1].textContent;

                    return tdA.localeCompare(tdB); 
                });
                
                for (let i=1; i<rows.length; i++){
                    table.appendChild(rows[i]);
                }  
        }

        function resetTable(){
            location.reload(); //reload the current page
        }


        buttonNothing.addEventListener('click', resetTable);
        buttonName.addEventListener('click', sortName);
        buttonSpeciality.addEventListener('click', sortSpeciality); 


        //table goals Name

       
        let sortNameUp = document.getElementById("sortArrowNameUp");
        sortNameUp.addEventListener('click', filterTableGoalsUp); 

        
        let sortNameDown = document.getElementById("sortArrowNameDown");
        sortNameDown.addEventListener('click', filterTableGoalsDown); 
       

        function filterTableGoalsUp(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[0].textContent; 
               let tdB = b.getElementsByTagName("td")[0].textContent;
               
               return tdA.localeCompare(tdB);

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        function filterTableGoalsDown(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[0].textContent; 
               let tdB = b.getElementsByTagName("td")[0].textContent;
               
               return tdB.localeCompare(tdA);

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        //table goals Count 

        let sortCountUp = document.getElementById("sortArrowCountUp");
        sortCountUp.addEventListener('click', filterTableCountUp); 

        let sortCountDown = document.getElementById("sortArrowCountDown");
        sortCountDown.addEventListener('click', filterTableCountDown); 
        
       

        function filterTableCountUp(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[1].textContent; 
               let tdB = b.getElementsByTagName("td")[1].textContent;
               
               return tdA-tdB; 

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        function filterTableCountDown(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[1].textContent; 
               let tdB = b.getElementsByTagName("td")[1].textContent;
               
               return tdB- tdA; 

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        //table goals search 
        let searchGoals = document.getElementById("searchgoals"); 
        searchGoals.addEventListener("input", searchGoal);

        function searchGoal(){
            let searchGoalsValue = searchGoals.value.trim().toUpperCase();
            
            let tableGoals = document.getElementById("tablegoals");
            let rows = tableGoals.getElementsByTagName("tr");
          

            for (let i=1; i< rows.length; i++){
                let td = rows[i].getElementsByTagName("td")[1];
                let tdValue = td.textContent.toUpperCase(); 

                
                if (tdValue.indexOf(searchGoalsValue)> -1){
                    rows[i].style.display = '';
                }else {
                    rows[i].style.display='none';
                }
            }   
        }

        //search referrals 
         // Get the input element
         var searchReferrals = document.getElementById("searchReferrals");

// Add event listener for input changes
        searchReferrals.addEventListener("input", function() {
        var filter = searchReferrals.value.toUpperCase();
        var tableReferrals = document.getElementById("tableReferrals");
        var rows = tableReferrals.getElementsByTagName("tr");

    // Iterate through each row of the table
    for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        var match = false;

        // Iterate through each cell of the row
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            // Check if the cell content contains the search keyword
            if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                match = true;
                break;
            }
        }

        // Show/hide the row based on the match
        if (match) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});

//table Students 
// Get the input element

      
//table counselors




