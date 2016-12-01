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
        -h | --help )           usage
                                exit
                                ;;
        * )                     usage
                                exit 1
    esac
    shift
done
name = $fwhm_$sig
figure_dir="$base_dir/$name"

matlabcommand="roou("$fwhm","$sig",'"$input_dir"','"$figure_dir"',0);quit"

matlab -nosplash -nodesktop -r $matlabcommand

cd pix2pix
DATA_ROOT=../$base_dir/$name name=$fwhm_$sig  which_direction=BtoA display=0 niter=20 batchSize=1 gpu=$user_gpu save_latest_freq=2000 checkpoints_dir=../$model_dir th train.lua
