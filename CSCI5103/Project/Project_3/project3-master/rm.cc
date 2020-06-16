#include "Kernel.h"
#include "DirectoryEntry.h"
#include "Stat.h"
#include <stdlib.h>
#include <string.h>

#define BUF_SIZE 4096
#define OUTPUT_MODE 0700

int main(int argc, char ** argv)
{
	char PROGRAM_NAME[8];
	strcpy(PROGRAM_NAME, "rm");

	// initialize the file system simulator kernel
	if(Kernel::initialize() == false) {
		cout << "Failed to initialized Kernel" << endl;
		Kernel::exit(1);
	}
	// print a helpful message if no command line arguments are given
	if(argc <= 1) {
		cout << PROGRAM_NAME << ": usage: " << PROGRAM_NAME << " input-file output-file";
		Kernel::exit( 1 ) ;
	}

	char name[512];
	memset(name, '\0', 512);
	
	// display a helpful message if no arguments are given
	// for each filename specified
	for(int i=1;i<argc;i++) {
		strcpy(name, argv[i]);

		int res = Kernel::unlink(name);
		if(res < 0) {
		    Kernel::perror(PROGRAM_NAME);
		    cout << PROGRAM_NAME <<" : Can't unlink directory " << name << endl;;
		    Kernel::exit(3);
		}
	}
}
