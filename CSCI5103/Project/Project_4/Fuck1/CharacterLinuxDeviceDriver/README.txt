Linux Device Driver Programming:

Name: BhagavathiDhass Thirunavukarasu
Email: thiru022@umn.edu


Compiling and installing the scullBuffer device:
--------------------------------------------------
1. Make for scullBuffer: 
   make
2. If scull devices already exist then unload them first.
   chmod +x unloadModule.py
   sudo ./unloadModule.py
3. Load scull devices (X can be any integer)
   chmod +x loadModule.py
   sudo ./loadModule.py scull_size=X
   This will create one scull buffer device: /dev/scullBuffer0
4. Make Consumer:
    	make consumer
5. Make Producer:
	make producer
6. Make Prodcon:
        make prodcon

Three methods to test the scullBuffer:

1. Test Manually:
$ echo "This is a test byte" | tee /dev/scullBuffer0
This is some test
$ cat /dev/scullBuffer0
This is a test byte

2. Test using prodcon.c (runs 3 producers and 2 consumers using pthreads - each producer produces 1000 items each of size 512):
  ./prodcon

3. Test using a Script:
/bin/sh test.sh
