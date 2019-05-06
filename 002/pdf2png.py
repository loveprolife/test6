from pdf2image import convert_from_path
from PIL import Image

Image.MAX_IMAGE_PIXELS = None

images = convert_from_path('/Users/wangpeng/Downloads/数据可视化/002/chuzhong_kexue.pdf', dpi=900)
images[0].save('/Users/wangpeng/Downloads/数据可视化/002/chuzhong_kexue.png')

images = convert_from_path('/Users/wangpeng/Downloads/数据可视化/002/chuzhong_yingyu.pdf', dpi=900)
images[0].save('/Users/wangpeng/Downloads/数据可视化/002/chuzhong_yingyu.png')

images = convert_from_path('/Users/wangpeng/Downloads/数据可视化/002/chuzhong_yuwen.pdf', dpi=900)
images[0].save('/Users/wangpeng/Downloads/数据可视化/002/chuzhong_yuwen.png')

images = convert_from_path('/Users/wangpeng/Downloads/数据可视化/002/gaozhong_shuxue.pdf', dpi=900)
images[0].save('/Users/wangpeng/Downloads/数据可视化/002/gaozhong_shuxue.png')

images = convert_from_path('/Users/wangpeng/Downloads/数据可视化/002/gaozhong_yingyu.pdf', dpi=900)
images[0].save('/Users/wangpeng/Downloads/数据可视化/002/gaozhong_yingyu.png')

images = convert_from_path('/Users/wangpeng/Downloads/数据可视化/002/gaozhong_yuwen.pdf', dpi=900)
images[0].save('/Users/wangpeng/Downloads/数据可视化/002/gaozhong_yuwen.png')



