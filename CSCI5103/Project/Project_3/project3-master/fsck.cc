/**
 * Fsck checks the file system for internal consistency, listing any problems detected to stdout.
 * It verifies that
 *  - all inodes mentioned in a directory have the correct number of nlinks.
 *  - all blocks mentioned in the inode are marked as allocated blocks.
 *  - all blocks not mentioned in the inode are marked as free blocks.
 */
#include "Kernel.h"
#include "DirectoryEntry.h"
#include "Stat.h"
#include <stdlib.h>
#include <string.h>

#define BUF_SIZE 4096
#define OUTPUT_MODE 0700

int main(int argc, char ** argv) {
    const char* PROGRAM_NAME = "fsck";

    // initialize the file system simulator kernel
    if(Kernel::initialize() == false) {
        cout << "Failed to initialized Kernel" << endl;
        Kernel::exit(1);
    }

    // Purely for testing, allow corupting the file system.
    if(argc == 2 && !strcmp(argv[1],"corrupt")){
        Kernel::corrupt();
        cout << "corrupted the filesystem" << endl;
        Kernel::exit(1);
        exit(0);
    }

    // print a helpful message if command line arguments are given
    if(argc != 1) {
        cout << PROGRAM_NAME << ": usage: " << PROGRAM_NAME;
        Kernel::exit(1) ;
    }

    // print out all inodes mentioned in directory entries.
    Kernel::fsck();

    Kernel::exit(0);
}

