<?php

require_once __DIR__ . '/bootstrap.php';


$url = "http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?msg=&categoryId=185749&langId=44&storeId=10151&krypto=2VdCpO0TfI1c3dS7gs4XdzVw3IqDOB3mQri3rdTuuHFjuWdI2THWQjOxGG8c%2FO9w33bSp0jy116e%0AAdTvwPqmiPWMqFQCMb712YcpeQnG7ePENixtXzYCbZgufbq0DskEd7%2BFDhJq%2Fa2hLqnNFVPk54Xa%0A0V8jSAtY2RSs5hAmLifLcHxz%2F9nT8%2BzY5eSc8N4sgIjQN9PBITdgWGt4blAmsS%2BR%2F6t3AxsTWqCb%0ATPt5%2BovGn51bJYZPoKcle3d4IqWDlYfjY8Z9pmK3T3SbO%2BZzucY8EGYWt2f2rtqIyn4vDAY%3D#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true";

$command = new SainsburysScraper\Command();
echo $command->execute($url);
