#Running it On AWS
## EC2 Public AMI
We provide an EC2 AMI with the following pre-installed packages:

* CUDA
* cuDNN
* torch
* Matlab(requires activation)

as well as the FITS file we used in the paper(saved in ~/fits_train and ~/fits_test)

AMI Id: ami-6f48b379
. (Can be launched using p2.xlarge instance in GPU compute catagory)

[Launch](https://console.aws.amazon.com/ec2/v2/home?region=us-east-1#LaunchInstanceWizard:ami=ami-6f48b379) an instance.
## Connect to Amazon EC2 Machine
Please follow the instruction of Amazon EC2.

note: If you get error like "nvidia-uvm 4.4.0-62 generic" was missing, this is because Amazon updated the kernal of the Ubuntu system, please re-install the cuda again.
## Activate Matlab
* follow the instructions on [mathworks website](http://www.mathworks.com/matlabcentral/answers/100407-how-do-i-transfer-a-concurrent-or-network-named-user-matlab-license-to-a-new-server) to generate a matlab license for the EC2 instance.
* put your license file `license.lic` in `~/` of the EC2 instance you created
* run script 
	`bash /usr/local/MATLAB/R2016b/bin/activate_matlab.sh -propertiesFile /home/ubuntu/activate.txt` to active matlab

## Get Our Code
	git clone --recursive https://github.com/SpaceML/GalaxyGAN.git
## Run Our Code
Please execute the following three commands and you will get the result that we got in our paper.
	
	cd GalaxyGAN
	bash train.sh -input ~/fits_train -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -model models
This will run the trainning on all FITS files in `~/fits_train`.

	bash test.sh -input ~/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -output result -model models -mode full
This will run the testing on all FITS files in `~/fits_test` and you can see the results in `result/1.4_1.2/latest_net_G_test/`.

	bash test.sh -input ~/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -output result -model models -mode blank
This will run the testing on all FITS files in `~/fits_test`, just the groundtruth is made blank to make sure the testing doesn't use the information of groundtruth image that we provide. In the `figures/test/` you can see the groundtruth are left blank and you can still get the same output in `result/1.4_1.2/latest_net_G_test/` as the previous command.
	

You can vary the parameters after `-fwhm` and `-sigma` to change the variance of gaussian filter and white noise level to the number you want.

It will take about 5 hours to train the model on an Amazon EC2 p2.xlarge instance. 

#Running It locally
## Get Our Code
	git clone --recursive https://github.com/SpaceML/GalaxyGAN.git
	cd GalaxyGAN

## Get and Unzip Our Fits Files
The data to download is about 5GB, after unzipping it will become about 16GB.

	bash download.sh 
## Run Our Code
Please execute the following three commands and you will get the result that we got in our paper.
	
	bash train.sh -input fitsdata/fits_train -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -model models
This will run the trainning on all FITS files in `fitsdata/fits_train`.

	bash test.sh -input fitsdata/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -output result -model models -mode full
This will run the testing on all FITS files in `fitsdata/fits_test` and you can see the results in `result/1.4_1.2/latest_net_G_test/`.

	bash test.sh -input fitsdata/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -output result -model models -mode blank
This will run the testing on all FITS files in `fitsdata/fits_test`, just the groundtruth is made blank to make sure the testing doesn't use the information of groundtruth image that we provide. In the `figures/test/` you can see the groundtruth are left blank and you can still get the same output in `result/1.4_1.2/latest_net_G_test/` as the previous command.
	

You can vary the parameters after `-fwhm` and `-sigma` to change the variance of gaussian filter and white noise level to the number you want.

It will take about 5 hours to train the model on an Amazon EC2 p2.xlarge instance. 
