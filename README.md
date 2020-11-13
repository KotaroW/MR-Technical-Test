# About This Repository

A little bit about this repository.

## Structure
- index.php
- aja.php (ajax processor)
- includes (Directory)
    - classes.php (multiple classes in a single file for the sake of brevity)
        - ProductCatalog (class) : 
        - Product (class)
        - My_Cart (class)
- css (Directory)
    - style.css (base stylesheet)
    - Gilroy-Light.otf (font face)
- js (Directory)
    - script.js
- image (Directory)
    - classic-tee.jpg

## How to access the test page
Please follow the below format otherwise the errror message will be displayed.
*[your own directory]/index.php?product=classic-tee*

## Please take note of that:
1. I overran the 5-hour time limit simply because I didn't want to stop this fun process. The estimated time spent is probably 8 hours or so, for which I will willingly accept any point reduction. I chopped this process into 2 days and I was thinking to come up with solutions during the intervals. I might have to add those times to the total time spent on this test (8 hours + ? hours).
2. I used Javascript "Arrow Notation" which does not work for the old platforms such as iOS 9. I conducted cross-browser checks for the layout but I stopped functionality testing for different platforms halfway through because my phone is an obsolete iOS.
3. As I didn't have time to set up a database for this project, I used a PHP (abstract) class, called Product_Catalog, as an alternative (please see Product_Catalog class in classes.php).
4. It's a single page website, any base stylesheets were used (no @import rules).
5. Some of the colour requirements were missed and some more work is needed to adjust the page layout.

## Known issues
To iterate through an array and process each array element, I used (array).map() function, however, (array).forEach() function would have been more suitable for that case. (In script.js at line 36). It could be rewritten:

```
<script>
    .....
    sizes.forEach(size => size.className = "");
    .....
</script>
```
Next thing is the layout for the Cart. According to the requirement, when opened, the Cart element needs to be enclosed in borders and the same requirement is applicable to the Cart item element. Currently, the layout looks as below:
![Cart Layout](https://raw.githubusercontent.com/KotaroW/MR-Technical-Test/main/image/classic-tee.jpg)



## Contact
Please feel free to contact me at <kotarochin@gmail.com> should you wish more detailed information.
Thanks very much for the time taken to read this.
