import cv2
import numpy as np
import sys
import os
''' 
usage
	preprocess.py full_file_directory file_name
'''

img = cv2.imread(sys.argv[1] + '/' + sys.argv[2])
img_reshaped = cv2.resize(img, (256, 256), interpolation = cv2.INTER_AREA)
z = np.zeros((256, 256, 3))
res = np.hstack((z, img_reshaped))
# cv2.imwrite(sys.argv[1] + '/prep_' + sys.argv[2], res)

cv2.imwrite(sys.argv[1] + '/' + "prep_" + sys.argv[2], res)
os.remove(sys.argv[1] + '/' + sys.argv[2])
os.rename(sys.argv[1] + '/' + "prep_" + sys.argv[2], sys.argv[1] + '/' + sys.argv[2])