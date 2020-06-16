
#include <stdio.h>

/* We want the extra information from these definitions */
#ifndef __USE_GNU
#define __USE_GNU
#endif
#include <ucontext.h>

#define SECOND 1000000
#define STACK_SIZE 4096

typedef unsigned long address_t;

char stack1[STACK_SIZE];
char stack2[STACK_SIZE];

ucontext_t cont[2];

void switchThreads();

void f()
{
	int i=0;
	while(1) {
		++i;
		printf("in f (%d)\n",i);
		if (i % 3 == 0) {
		    printf("f: switching\n");
		    switchThreads();
		}
		usleep(SECOND);
	}
}

void g()
{
	int i=0;
	while(1){
		++i;
		printf("in g (%d)\n",i);
		if (i % 5 == 0) {
		    printf("g: switching\n");
		    switchThreads();
		}
		usleep(SECOND);
	}
}


void setup()
{
	address_t sp, pc;

	sp = (address_t)stack1 + STACK_SIZE - sizeof(int); 
	pc = (address_t)f;

	// Get the current execution context
	getcontext(&cont[0]);

	// Modify the context to a new stack
	cont[0].uc_mcontext.gregs[REG_RIP] = pc;
	cont[0].uc_mcontext.gregs[REG_RSP] = sp;
	sigemptyset(&cont[0].uc_sigmask);     

	sp = (address_t)stack2 + STACK_SIZE - sizeof(int);
	pc = (address_t)g;

	getcontext(&cont[1]);

	cont[1].uc_mcontext.gregs[REG_RIP] = pc;
	cont[1].uc_mcontext.gregs[REG_RSP] = sp;
	sigemptyset(&cont[1].uc_sigmask);     
}


void switchThreads()
{
	static int currentThread = 0;

	volatile int flag = 0;
	int ret_val = getcontext(&cont[currentThread]);
	printf("SWITCH: currentThread=%d\n", currentThread); 
	if (flag == 1) {
	    return;
	}

	currentThread = 1 - currentThread;
	flag = 1;
	setcontext(&cont[currentThread]);
}


int main()
{
	setup();		
	setcontext(&cont[0]);
	return 0;
}
