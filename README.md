#EC2 Public AMI
EC2 AMI with the following pre-installed packages:

* CUDA
* cuDNN
* torch
* Matlab(requires activation)

as well as the FITS file we used in the paper(saved in ~/fits_train and ~/fits_test)

AMI Id: xxxx. (Can be launched using g2.2xlarge instance)

[Launch](https://console.aws.amazon.com/ec2/v2/home?region=us-east-1#LaunchInstanceWizard:ami=xxx) an instance.
#Connect to Amazon EC2 machine
Please follow the instruction of Amazon EC2
#Activate Matlab
* put your license file `license.lic` in `~/`
* run script 
	`bash activate_matlab.sh /usr/local/MATLAB/R2016b/bin/activate_matlab.sh -propertiesFile /home/ubuntu/activate.txt`

#Get Our Code
	git pull --recursive https://github.com/DS3Lab/roou.git

#Run our code
Please execute the following three commands and you will get the result the we got in our paper.
	
	cd roou
	bash train.sh -input ~/fits_train -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -name FITS001002 -model models
	bash test.sh -input ~/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -name FITS001001 -output result -model models
You can vary the parameters after -fwhm and -sigma to change the variance of gaussian filter and white noise level.

The results are shown in `/result/FITS001002/latest_net_G_test/`
You can open the `index.html` to see the result. 