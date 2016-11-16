# jbrbo

## 1. Create some data

### Job posts
/admin/structure/posted_job/add

### Users

## 2. Review Posts
/myjobs

Press **Accept** or **Reject**, but not Save

## 3. See Reviewed Posts archive
/admin/structure/reviewed_posts


## NEW / scratch: Applicant list (related with Posted Job)
open link:
 <br>
 /posted_job/{job_posts}

> example: **/posted_job/4**

Click on Applicant list and applicant list will open (related with posted job) right now empty.
Need to write some code in applicantList($posted_job) method in modules/custom/matching/src/Controller/MatchingController.php
