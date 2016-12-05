#EC2 Public AMI
We provide an EC2 AMI with the following pre-installed packages:

* CUDA
* cuDNN
* torch
* Matlab(requires activation)

as well as the FITS file we used in the paper(saved in ~/fits_train and ~/fits_test)

AMI Id: ami-bffec6a8. (Can be launched using p2.xlarge instance in GPU compute catagory)

[Launch](https://console.aws.amazon.com/ec2/v2/home?region=us-east-1#LaunchInstanceWizard:ami=ami-bffec6a8) an instance.
#Connect to Amazon EC2 Machine
Please follow the instruction of Amazon EC2.
#Activate Matlab
* put your license file `license.lic` in `~/`
* run script 
	`bash activate_matlab.sh /usr/local/MATLAB/R2016b/bin/activate_matlab.sh -propertiesFile /home/ubuntu/activate.txt` to active matlab

#Get Our Code
	git clone --recursive https://github.com/DS3Lab/roou.git

#Run our code
Please execute the following three commands and you will get the result that we got in our paper.
	
	cd roou
	bash train.sh -input ~/fits_train -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -model models
This will run the trainning on all FITS files in `~/fits_train`.

	bash test.sh -input ~/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -output result -model models -mode full
This will run the testing on all FITS files in `~/fits_test` and you can see the results in `result/1.4_1.2/latest_net_G_test/`.

	bash test.sh -input ~/fits_test -fwhm 1.4 -sigma 1.2 -figure figures -gpu 1 -output result -model models -mode blank
This will run the testing on all FITS files in `~/fits_test`, just the groundtruth is made blank to make sure the testing doesn't use the information of groundtruth image that we provide. In the `figures/test/` you can see the groundtruth are left blank and you can still get the same output in `result/1.4_1.2/latest_net_G_test/` as the previous command.
	

You can vary the parameters after `-fwhm` and `-sigma` to change the variance of gaussian filter and white noise level to the number you want.

It will take about 5 hours to train the model on an Amazon EC2 p2.xlarge instance. 