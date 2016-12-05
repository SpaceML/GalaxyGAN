function roou(fwhm,sig,input_folder,figure_folder,mode) 
%fwhm: Full width at Half Maximum in arc seconds for gaussian filter
%sig: White Noise level
%mode: 0:training 1:testing    
    %not demo
    is_demo = 0;
    
    %set default values
    if ~exist('fwhm','var')
        fwhm = 1.4;
    end
    if ~exist('sig','var')
        sig = 1.2;
    end
    if ~exist('input_folder','var')
        input_folder = './fits_0.01_0.02';
    end
    
    if ~exist('figure_folder','var')
        figure_folder = './figures/test';
    end
    
    if ~exist(figure_folder, 'dir')
        mkdir(figure_folder);
    end
    train_folder = sprintf('%s/train',figure_folder);
    test_folder = sprintf('%s/test',figure_folder);
    deconv_folder = sprintf('%s/deconv',figure_folder);
    if ~exist(train_folder, 'dir')
        mkdir(train_folder);
    end
    if ~exist(test_folder, 'dir')
        mkdir(test_folder);
    end
    if ~exist(deconv_folder, 'dir')
        mkdir(deconv_folder);
    end
    fits = sprintf('%s/*/*-g.fits',input_folder);
    files = dir(fits);

    for i = 1:size(files,1)
        file_name = files(i).name;

        %% readfiles
        if is_demo
            file_name = '587725489986928743';
            fwhm = 1.4; 
            sig = 1.2; 
            mode = 1;
            input_folder='fits_0.01_0.02'; 
            figure_folder='figures';
        end
        filename = erase(file_name,'-g.fits');
        filename_g = sprintf('%s/%s/%s-g.fits',input_folder,filename,filename);
        filename_r = sprintf('%s/%s/%s-r.fits',input_folder,filename,filename);
        filename_i = sprintf('%s/%s/%s-i.fits',input_folder,filename,filename);


        data_g = fitsread(filename_g);
        data_r = fitsread(filename_r);
        data_i = fitsread(filename_i);

        figure_original = ones(size(data_g,1),size(data_g,2),3);
        figure_original(:,:,1) = data_i;
        figure_original(:,:,2) = data_r;
        figure_original(:,:,3) = data_g;
        
        if is_demo
            imshow(figure_original)
        end
        %% gaussian filter
        fwhm_use = fwhm/0.396;
        gaussian_sigma = fwhm_use / 2.355;
        figure_blurred = imgaussfilt(figure_original,gaussian_sigma);
        
        if is_demo
            imshow(figure_blurred)
        end
        
        %% add white noise
        figure_original_nz =  figure_original(figure_original<0.1);
        figure_original_nearzero = figure_original_nz(figure_original_nz>-0.1);
        figure_blurred_nz = figure_blurred(figure_blurred<0.1);
        figure_blurred_nearzero = figure_blurred_nz(figure_blurred_nz>-0.1);
        [m,s] = normfit(figure_original_nearzero);
        [m2,s2] = normfit(figure_blurred_nearzero);
        
        whitenoise_var = (sig*s)^2-s2^2;

        if whitenoise_var < 0
            whitenoise_var = 0.00000001;
        end

        whitenoise_energylevel = log(whitenoise_var)/log(10)*10;

        whitenoise = wgn(size(data_g,1),size(data_g,2),whitenoise_energylevel);
        figure_blurred(:,:,1) = figure_blurred(:,:,1) + whitenoise;
        figure_blurred(:,:,2) = figure_blurred(:,:,2) + whitenoise;
        figure_blurred(:,:,3) = figure_blurred(:,:,3) + whitenoise;

        if is_demo
            imshow(figure_blurred)
        end
        %% deconvolution
        if mode   
            hsize = 2*ceil(2*gaussian_sigma)+1 ;
            PSF = fspecial('gaussian', hsize, gaussian_sigma);
            figure_deconv = deconvblind(figure_blurred, PSF);
            %figure_deconv = deconvlucy(figure_blurred, PSF);
            if is_demo
                imshow(figure_deconv)
            end
        end
        %% thresold
        MAX = 4;
        MIN = -0.1;

        figure_original(figure_original<MIN)=MIN;
        figure_original(figure_original>MAX)=MAX;

        figure_blurred(figure_blurred<MIN)=MIN;
        figure_blurred(figure_blurred>MAX)=MAX;
        if mode
            figure_deconv(figure_deconv<MIN)=MIN;
            figure_deconv(figure_deconv>MAX)=MAX;
        end
        %% normalize figures
        figure_original = (figure_original-MIN)/(MAX-MIN);
        figure_blurred = (figure_blurred-MIN)/(MAX-MIN);
        if mode
            figure_deconv = (figure_deconv-MIN)/(MAX-MIN);
            if is_demo
                subplot(1,3,1), subimage(figure_original), subplot(1,3,2), subimage(figure_blurred),subplot(1,3,3), subimage(figure_deconv)
            end
        elseif is_demo
            subplot(1,2,1), subimage(figure_original), subplot(1,2,2), subimage(figure_blurred)
        end
        
        %% asinh scaling
        figure_original = asinh(10*figure_original)/3;
        figure_blurred = asinh(10*figure_blurred)/3;
        
        if mode
            figure_deconv = asinh(10*figure_deconv)/3;
        end
       
        %% output result to pix2pix format
        figure_combined = zeros(size(data_g,1),size(data_g,2)*2,3);
        figure_combined(:,1:size(data_g,2),:) = figure_original(:,:,:);
        figure_combined(:,size(data_g,2)+1:2*size(data_g,2),:) = figure_blurred(:,:,:);
        
        if is_demo
            imshow(figure_combined)
        end
        if mode
            jpg_path = sprintf('%s/test/%s.jpg',figure_folder,filename);
        else
            jpg_path = sprintf('%s/train/%s.jpg',figure_folder,filename);
        end
        if mode == 2
            figure_combined_no_ori = zeros(size(data_g,1),size(data_g,2)*2,3);
            figure_combined_no_ori(:,size(data_g,2)+1:2*size(data_g,2),:) = figure_blurred(:,:,:);
            imwrite(figure_combined_no_ori,jpg_path);
        else
            imwrite(figure_combined,jpg_path);
        end
        if mode
            deconv_path = sprintf('%s/deconv/%s.jpg',figure_folder,filename);
            imwrite(figure_deconv,deconv_path);
        end
    end
end



