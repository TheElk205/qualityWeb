<?php
/**
 * Created by PhpStorm.
 * User: Ferdi
 * Date: 15.12.2015
 * Time: 13:12
 */
require_once '../autoload.php';

use \quality\QualityApi as QualityApi;
        $foldername = "content";
        $files = array();
        if (file_exists($foldername) || mkdir($foldername)) {
            $qualityApi = new QualityApi();

            $qualitiesListFile = fopen($foldername . "\\qualitiesList.txt", "w") or die("Unable to open file!");
            fwrite($qualitiesListFile, $qualityApi->getQualityIdsJson());
            fclose($qualitiesListFile);
            array_push($files, $foldername . "\\qualitiesList.txt");

            $qualityTestsListFile = fopen($foldername . "\\qualityTestsList.txt", "w") or die("Unable to open file!");
            fwrite($qualityTestsListFile, $qualityApi->getQualityTestIdsJson());
            fclose($qualityTestsListFile);
            array_push($files, $foldername . "\\qualityTestsList.txt");

            //Save all Qualities
            //First general, then PSNR ans SSIM
            $qualityFolder = $foldername . "\\qualities";
            if (file_exists($qualityFolder) || mkdir($qualityFolder)) {
                foreach ($qualityApi->getQualityIds()->getAllIds() as $qualityId) {
                    $qualityFolder = $foldername . "\\qualities\\" . $qualityId;
                    if (file_exists($qualityFolder) || mkdir($qualityFolder)) {
                        $qualityInfoFile = fopen($qualityFolder . "\\info.txt", "w") or die("Unable to open file!");
                        fwrite($qualityInfoFile, $qualityApi->getQualityWithIdJson($qualityId));
                        fclose($qualityInfoFile);
                        array_push($files, $qualityFolder . "\\info.txt");

                        $qualityPSNRFile = fopen($qualityFolder . "\\psnr.txt", "w") or die("Unable to open file!");
                        fwrite($qualityPSNRFile, $qualityApi->getPSNROfIDJson($qualityId));
                        fclose($qualityPSNRFile);
                        array_push($files, $qualityFolder . "\\psnr.txt");

                        $qualitySSIMFile = fopen($qualityFolder . "\\ssim.txt", "w") or die("Unable to open file!");
                        fwrite($qualitySSIMFile, $qualityApi->getSSIMOfIDJson($qualityId));
                        fclose($qualitySSIMFile);
                        array_push($files, $qualityFolder . "\\ssim.txt");
                    }
                }
            }

            //Save all QualityTests
            //First general, then PSNR ans SSIM
            $qualityFolder = $foldername . "\\qualityTests";
            if (file_exists($qualityFolder) || mkdir($qualityFolder)) {
                foreach ($qualityApi->getQualityTestIds()->getAllIds() as $qualityTestId) {
                    $qualityTestFolder = $foldername . "\\qualityTests\\" . $qualityTestId;
                    if (file_exists($qualityTestFolder) || mkdir($qualityTestFolder)) {
                        $qualityTestInfoFile = fopen($qualityTestFolder . "\\info.txt", "w") or die("Unable to open file!");
                        fwrite($qualityTestInfoFile, $qualityApi->getQualityTestWithIdJson($qualityTestId));
                        fclose($qualityTestInfoFile);
                        array_push($files, $qualityTestFolder . "\\info.txt");
                    }
                }
            }
        }

        //Zip it
        $zip = new ZipArchive();
        //var_dump($files);
        $zipFilename = $foldername . ".zip";
        $file = fopen($zipFilename, "w");
        fclose($file);

        $zip->open($zipFilename, ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file);
        }
        $zip->close();

        header('Content-disposition: attachment; filename=qualityData.zip');
        header('Content-type: application/zip');
        readfile($zipFilename);
    ?>