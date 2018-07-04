<?php
if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 1))
{
    $my_url .= "?menuitem=" . $menuitem;
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    } else {
        $action = "";
    }
	
	if ($db->isGroupRole($schemas, $sess_profile, $sess_user_id, 2, 2))
	{
		require("modules/upload_document.class.php");

		if (isset($_POST["insertanimalinfobttn"]) && (int) $_POST["insertanimalinfobttn"] == 1) 
		{
			if (isset($_POST["species_code"])) 
			{
				$species_code = (int) $_POST["species_code"];
	
				$fauna_filename1 = "";
				$picture_pathname = "";
	
				if (is_uploaded_file($_FILES['fauna_filename1']['tmp_name']))
				{
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '20');
					$uploader->uploader_set($_FILES['fauna_filename1'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$fauna_filename1 = $uploader->uploaded_files[0];
						$picture_pathname = $path;
						$fauna_filename1 = $fauna_filename1;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
				
				$fauna_filename2 = "";
				
	
				if (is_uploaded_file($_FILES['fauna_filename2']['tmp_name'])) {
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '20');
					$uploader->uploader_set($_FILES['fauna_filename2'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$fauna_filename2 = $uploader->uploaded_files[0];
						$picture_pathname = $path;
						$fauna_filename2 = $fauna_filename2;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
				
				$fauna_filename3 = "";
				
	
				if (is_uploaded_file($_FILES['fauna_filename3']['tmp_name'])) {
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '20');
					$uploader->uploader_set($_FILES['fauna_filename3'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$fauna_filename3 = $uploader->uploaded_files[0];
						$picture_pathname = $path;
						$fauna_filename3 = $fauna_filename3;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
				
				$dist_filename = "";
				
	
				if (is_uploaded_file($_FILES['dist_filename']['tmp_name'])) {
					$today = date('Y-m-d');
	
					$file = "files/index.php";
					$year = date("Y", strtotime($today));
					$path = "upload/" . $year;
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
					$path = $path . "/" . $species_code . "/";
					if (!is_dir($path)) {
						mkdir($path, 0775);
						chmod($path, 0775);
						copy($file, $path . "/index.php");
					}
	
					$uploader = new file_upload();
					$uploader->first_values('', '_' . $species_code, 'MB', '20');
					$uploader->uploader_set($_FILES['dist_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);
	
					if ($uploader->uploaded) {
						$dist_filename = $uploader->uploaded_files[0];
						$picture_pathname = $path;
						$dist_filename = $dist_filename;
					} else {
						show_notification("error", "", $uploader->error);
					}
				}
	
				$fields = array("species_code", "description_mn", "description_en", "distribution_mn", "distribution_en", "habitat_mn", "habitat_en", "benefit_mn", "benefit_en", "fauna_filename1", "fauna_filename2", "fauna_filename3", "dist_filename", "picture_pathname", "user_id");
	
				$checkvalues = array((int) $_POST["species_code"], $_POST["description_mn"], $_POST["description_en"], $_POST["distribution_mn"], $_POST["distribution_en"], $_POST["habitat_mn"], $_POST["habitat_en"], $_POST["benefit_mn"], $_POST["benefit_en"], $fauna_filename1, $fauna_filename2, $fauna_filename3, $dist_filename, $picture_pathname, $sess_user_id);
	
				$values = array();
				for ($i = 0; $i < sizeof($checkvalues); $i++) {
					$values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
				}
	
				$result = $db->insert("" . $schemas . ".taanimalinfo", $fields, $values);
				if (!$result)
					show_notification("error", "", "Нэмэх явцад алдаа гарлаа. Та дахин оролдоно уу.");
				else
					show_notification("success", "", "Таны мэдээлэл амжилттай нэмэгдлээ.");
			}
		}

        if (isset($_POST["updateanimalinfobttn"]) && (int) $_POST["updateanimalinfobttn"] == 1) 
		{
            if (isset($_POST["species_code"]) && isset($_POST["basic_id"])) 
			{
                $wherevalues = "basic_id=" . (int) $_POST["basic_id"];
                $species_code = (int) $_POST["species_code"];

                $fauna_filename1 = "";
                $picture_pathname = "";

                if (is_uploaded_file($_FILES['fauna_filename1']['tmp_name']))
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '20');
                    $uploader->uploader_set($_FILES['fauna_filename1'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

					if ($uploader->uploaded) {
                        if (!empty($_POST["picture_pathname"]) && !empty($_POST["fauna_filename1"]))
                            unlink($_POST["picture_pathname"] . $_POST["fauna_filename1"]);
                        $fauna_filename1 = $uploader->uploaded_files[0];
                        $picture_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["picture_pathname"]) && !empty($_POST["picture_pathname"]) && isset($_POST["fauna_filename1"]) && !empty($_POST["fauna_filename1"])) {
                        $fauna_filename1 = $_POST["fauna_filename1"];
                        $picture_pathname = $_POST["picture_pathname"];
                    }
                }

                $fauna_filename2 = "";
                $picture_pathname = "";

                if (is_uploaded_file($_FILES['fauna_filename2']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '20');
                    $uploader->uploader_set($_FILES['fauna_filename2'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

                    if ($uploader->uploaded) {
                        if (!empty($_POST["picture_pathname"]) && !empty($_POST["fauna_filename2"]))
                            unlink($_POST["picture_pathname"] . $_POST["fauna_filename2"]);
                        $fauna_filename2 = $uploader->uploaded_files[0];
                        $picture_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["picture_pathname"]) && !empty($_POST["picture_pathname"]) && isset($_POST["fauna_filename2"]) && !empty($_POST["fauna_filename2"])) {
                        $fauna_filename2 = $_POST["fauna_filename2"];
                        $picture_pathname = $_POST["picture_pathname"];
                    }
                }

                $fauna_filename3 = "";
                $picture_pathname = "";

                if (is_uploaded_file($_FILES['fauna_filename3']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '20');
                    $uploader->uploader_set($_FILES['fauna_filename3'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

                    if ($uploader->uploaded) {
                        if (!empty($_POST["picture_pathname"]) && !empty($_POST["fauna_filename3"]))
                            unlink($_POST["picture_pathname"] . $_POST["fauna_filename3"]);
                        $fauna_filename3 = $uploader->uploaded_files[0];
                        $picture_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["picture_pathname"]) && !empty($_POST["picture_pathname"]) && isset($_POST["fauna_filename3"]) && !empty($_POST["fauna_filename3"])) {
                        $fauna_filename3 = $_POST["fauna_filename3"];
                        $picture_pathname = $_POST["picture_pathname"];
                    }
                }

                $dist_filename = "";
                $picture_pathname = "";

                if (is_uploaded_file($_FILES['dist_filename']['tmp_name'])) 
				{
                    $today = date('Y-m-d');

                    $file = "files/index.php";
                    $year = date("Y", strtotime($today));
                    $path = "upload/" . $year;
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $_MY_CONF["ANIMALINFO_PATH"];
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }
                    $path = $path . "/" . $species_code . "/";
                    if (!is_dir($path)) {
                        mkdir($path, 0775);
                        chmod($path, 0775);
                        copy($file, $path . "/index.php");
                    }

                    $uploader = new file_upload();
                    $uploader->first_values('', '_' . $species_code, 'MB', '20');
                    $uploader->uploader_set($_FILES['dist_filename'], date("Y", strtotime($today)) . date("m", strtotime($today)) . date("d", strtotime($today)), $path, $PICTURE_TYPES);

                   
                 	if ($uploader->uploaded) {
                        if (!empty($_POST["picture_pathname"]) && !empty($_POST["dist_filename"]))
                            unlink($_POST["picture_pathname"] . $_POST["dist_filename"]);
                        $dist_filename = $uploader->uploaded_files[0];
                        $picture_pathname = $path;
                    } else {
                        show_notification("error", "", $uploader->error);
                    }
                } else {
                    if (isset($_POST["picture_pathname"]) && !empty($_POST["picture_pathname"]) && isset($_POST["dist_filename"]) && !empty($_POST["dist_filename"])) {
                        $dist_filename = $_POST["dist_filename"];
                        $picture_pathname = $_POST["picture_pathname"];
                    }
                }

                $fields = array("species_code", "description_mn", "description_en", "distribution_mn", "distribution_en", "habitat_mn", "habitat_en", "benefit_mn", "benefit_en", "fauna_filename1", "fauna_filename2", "fauna_filename3", "dist_filename", "picture_pathname", "user_id");


                $checkvalues = array((int) $_POST["species_code"], $_POST["description_mn"], $_POST["description_en"], $_POST["distribution_mn"], $_POST["distribution_en"], $_POST["habitat_mn"], $_POST["habitat_en"], $_POST["benefit_mn"], $_POST["benefit_en"], $fauna_filename1, $fauna_filename2, $fauna_filename3, $dist_filename, $picture_pathname, (int) $_POST["user_id"]);


                $values = array();
                for ($i = 0; $i < sizeof($checkvalues); $i++) {
                    $values[$i] = (empty($checkvalues[$i]) ? "NULL" : "'" . $checkvalues[$i] . "'");
                }

                $result = $db->update("" . $schemas . ".taanimalinfo", $fields, $values, $wherevalues);
                if (!$result)
                    show_notification("error", "", "Өөрчлөх явцад алдаа гарлаа. Та дахин оролдоно уу.");
                else
                    show_notification("success", "", "Таны мэдээлэл амжилттай засагдлаа.");
            }
        }

        if (($action == "delete") && isset($_GET["basic_id"])) 
		{
            $basic_id = (int) $_GET["basic_id"];

            if ($sess_profile == 1)
                $wherevalues = "basic_id = " . $basic_id;
            else
                $wherevalues = "basic_id = " . $basic_id . " AND user_id = " . $sess_user_id;

            $selQuery = "SELECT fauna_filename1, fauna_filename2, fauna_filename3, dist_filename, picture_pathname FROM " . $schemas . ".taanimalinfo WHERE " . $wherevalues;
            $rowfile = $db->query($selQuery);

            $result = $db->delete("" . $schemas . ".taanimalinfo", $wherevalues);
            if (!$result) {
                show_notification("error", "", "Устгах явцад алдаа гарлаа. Та дахин оролдоно уу.");
            } else {
                show_notification("success", "", "Таны мэдээлэл амжилттай устлаа.");
                if (!empty($rowfile)) {
					if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["fauna_filename1"]))
						unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["fauna_filename1"]);
					if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["fauna_filename2"]))
						unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["fauna_filename2"]);
					if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["fauna_filename3"]))
						unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["fauna_filename3"]);
					if (!empty($rowfile[0]["picture_pathname"]) && !empty($rowfile[0]["dist_filename"]))
						unlink($rowfile[0]["picture_pathname"] . $rowfile[0]["dist_filename"]);
                }
            }
        }
    }

    $page = (isset($_GET["page"]) && (int) $_GET["page"] > 0) ? (int) $_GET["page"] : 1;
    $my_page = "&page=" . $page;

    $searchQuery = "";
    $search_url = "";

    $species_name_mn = (isset($_GET["species_name_mn"])) ? $_GET["species_name_mn"] : "";
	$species_name = (isset($_GET["species_name"])) ? $_GET["species_name"] : "";
    $class_name_mn = (isset($_GET["class_name_mn"])) ? $_GET["class_name_mn"] : "";
    $family_name_mn = (isset($_GET["family_name_mn"])) ? $_GET["family_name_mn"] : "";
    $order_name_mn = (isset($_GET["order_name_mn"])) ? $_GET["order_name_mn"] : "";

    if (empty($class_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {
        $searchQuery .= " AND lower(tacn.class_name_mn) LIKE lower('%" . $class_name_mn . "%')";
        $search_url .= "&class_name_mn=" . $class_name_mn;
    }

    if (empty($family_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {

        $searchQuery .= " AND lower(tafn.family_name_mn) LIKE lower('%" . $family_name_mn . "%')";
        $search_url .= "&family_name_mn=" . $family_name_mn;
    }

    if (empty($order_name_mn)) {
        $searchQuery .= "";
        $search_url .= "";
    } else {

        $searchQuery .= " AND lower(taon.order_name_mn) LIKE lower('%" . $order_name_mn . "%')";
        $search_url .= "&order_name_mn=" . $order_name_mn;
    }

    if(empty($species_name_mn))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name_mn) LIKE lower('%".$species_name_mn."%') OR lower(tagn.genus_name_mn) LIKE lower('%".$species_name_mn."%') )";
		$search_url .= "&species_name_mn=".$species_name_mn;
	}
	
	if(empty($species_name))
	{
		$searchQuery .= "";
		$search_url .= "";
	}else
	{
		$searchQuery .= " AND (lower(tapl.species_name) LIKE lower('%".$species_name."%') OR lower(tagn.genus_name) LIKE lower('%".$species_name."%') )";
		$search_url .= "&species_name=".$species_name;
	}

    $sort_url = "";
    $sort = (isset($_GET["sort"])) ? (int) $_GET["sort"] : 0;
    $sort_type = (isset($_GET["sorttype"])) ? (int) $_GET["sorttype"] : 0;

    if ($sort == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sort=" . $sort;

    if ($sort_type == 0)
        $sort_url .= "";
    else
        $sort_url .= "&sorttype=" . $sort_type;

    if ($action == "edit") {
        require("taanimalinfo/inc.edit_animalinfoform.php");
    }  elseif ($action == "add") {
        require("taanimalinfo/inc.add_animalinfoform.php");
    } elseif ($action == "more") {
        require("taanimalinfo/inc.more_animalinfoform.php");
    } else {
        require("taanimalinfo/inc.list_animalinfoform.php");
    }
} else {
    $notify = "Таны хандалт буруу байна.";
    show_notification("error", "", $notify);
}
?>
