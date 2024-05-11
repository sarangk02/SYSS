 <!-- contact -->
 <div id="contact" class="container position-relative">

     <div class="form-container">
         <div>
             <h1 class="text-center">Any problem ??<br>Feel free to contact Experts</h1>
         </div>
         <hr style="color:#D91A21;">


         <form action="index.php" method="post">
             <div class="mb-2 w-75 mx-auto">
                 <label for="formname" class="form-label">Name</label>
                 <label class="output-label form-label"><?php echo $first_name . " " . $last_name ?></label>
             </div>
             <div class="mb-2 w-75 mx-auto">
                 <label for="formquery" class="form-label">Query</label>
                 <textarea placeholder="Describe your Detailed Problem/Query" rows="4" class="c-input form-control" id="formquery" name="formquery" required></textarea>
             </div>
             <div class="mt-3 d-grid gap-2 col-6 mx-auto">
                 <!-- Button trigger modal -->
                 <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#query_confirm">Luanch Query</button>

                 <!-- Modal -->
                 <div class="modal fade" id="query_confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="staticBackdropLabel">Confirm ?</h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                 <p>Are you sure you want to submit the query?</p>
                             </div>
                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-outline-danger">Yes, I'm sure.</button>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>
         </form>
         <hr style="color:#D91A21;">
     </div>
 </div>