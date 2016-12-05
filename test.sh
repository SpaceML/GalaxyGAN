#!/bin/bash
## Functions
function usage
{
    echo "usage: bash train.sh [[[-f file ] [-i]] | [-h]]"
}


## Main

while [ "$1" != "" ]; do
    case $1 in
        -input  )               shift
                                input_dir=$1
                                ;; 
        -fwhm   )               shift
                                fwhm=$1
                                ;;
        -sigma  )               shift
                                sig=$1
                                ;;  
        -figure )               shift
                                base_dir=$1
                                ;;
	-pipeline )             shift
				pipeline=$1
				;;
        -gpu    )               shift
                                user_gpu=$1
                                ;; 
        -name   )               shift
				name=$1
				;;
	-model )		shift
				model_dir=$1
				;;
	-output )		shift
				result_dir=$1
				;;
	-mode )			shift
				mode=$1
				;;
        -h | --help )           usage
                                exit
                                ;;
        * )                     usage
                                exit 1
    esac
    shift
done
name=$fwhm"_"$sig
figure_dir="$base_dir/$name"
if [ "$mode"==full ]; then
    matlabcommand="roou("$fwhm","$sig",'"$input_dir"','"$figure_dir"',1);quit"
else
    matlabcommand="roou("$fwhm","$sig",'"$input_dir"','"$figure_dir"',2);quit"
fi
matlab -nosplash -nodesktop -r $matlabcommand

cd pix2pix
DATA_ROOT=../$base_dir/$name name=$fwhm"_"$sig which_direction=BtoA phase=test display=0 gpu=$user_gpu checkpoints_dir=../$model_dir results_dir=../$result_dir th test.lua
cd ../$result_dir/$name/latest_net_G_test/
mkdir images/deconv
mogrify -path images/deconv -resize 256x256 -quality 100 ../../../$figure_dir/deconv/*.jpg
