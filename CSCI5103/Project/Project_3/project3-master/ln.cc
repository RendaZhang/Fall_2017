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
	strcpy(PROGRAM_NAME, "ln");

	// initialize the file system simulator kernel
	if(Kernel::initialize() == false)
	{
		cout << "Failed to initialized Kernel" << endl;
		Kernel::exit(1);
	}
	// print a helpful message if no command line arguments are given
	if(argc != 3)
	{
		cout << PROGRAM_NAME << ": usage: " << PROGRAM_NAME << " input-file output-file";
		Kernel::exit(2);
	}

	// give the parameters more meaningful names
	char in_name[64];
	char out_name[64];

	strcpy(in_name, argv[1]);
	strcpy(out_name, argv[2]);

	// open the input file
	int in_fd = Kernel::open(in_name , Kernel::O_RDONLY);

	if(in_fd < 0) {
		Kernel::perror(PROGRAM_NAME);
		cout << PROGRAM_NAME << ": unable to open input file \"" << in_name << "\"";
		Kernel::exit(2) ;
	}

	Kernel::link(in_name, out_name);

	// close the files
	Kernel::close(in_fd);
}
