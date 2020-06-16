#!/usr/bin/env python3

# Name: Renda Zhang
# Email: zhan4067@umn.edu
# Due Date: Oct 29, 2017

# Make sure the following file
# exists and in the same directory:
# 202.html 400.html 403.html 404.html

import os
import os.path
import stat
import socket
import re

from threading import Thread
from argparse import ArgumentParser

BUFSIZE = 4096
CRLF = '\r\n'
OK = 'HTTP/1.1 200 OK' + CRLF
NOT_FOUND = 'HTTP/1.1 404 Not Found' + CRLF
FORBIDDEN = 'HTTP/1.1 403 Forbidden' + CRLF
NOT_ACCEPTABLE = 'HTTP/1.1 406 Not Acceptable' + CRLF
ACCEPTED = 'HTTP/1.1 202 Accepted' + CRLF
BAD_REQUEST = 'HTTP/1.1 400 Bad Request' + CRLF
MOVED_PERMANENTLY = 'HTTP/1.1 301 Moved Permantly' + CRLF
METHOD_NOT_ALLOWED = ('HTTP/1.1 405 Method Not Allowed' +
                      CRLF + 'Allow: GET, HEAD, POST' +
                      CRLF + 'Connection: close' +
                      CRLF)

# function for processing data
def process_data(data, sock):
    # Server logs requestes to STDIN 
    print(data)
    
    # Get all the lines from client data
    lines = data.split('\n')
    # get the first line and check if it is blank line
    request_line = lines[0].strip()
    if request_line:
      items = request_line.split()
      method = items[0]
      if len(items) == 3:
        resource = items[1]
        protocol = items[2]
      elif len(items) == 2:
        resource = items[1]
        protocol = ''
      else:
        resource = ''
        protocol = ''
    else:
      method = ''
    
    # check if a protocl is http 1.1
    if protocol != 'HTTP/1.1':
      protocol = ''
    

    if method == 'GET' or method == 'HEAD':
      # check for redirection for csumn 301
      if "/csumn" == resource:
        if method == 'HEAD':
          result = MOVED_PERMANENTLY + CRLF + CRLF
          sock.send(result.encode())
          return
        header = ('Location: https://www.cs.umn.edu/'+
                  CRLF + 'Connection: close' + CRLF)
        result = MOVED_PERMANENTLY + header + CRLF
        sock.send(result.encode())
        return
      
      # check for bad request 400
      if "bad%request.html" in resource or protocol == '':
        if method == 'HEAD': # send and return for HEAD
          result = BAD_REQUEST + CRLF + CRLF
          sock.send(result.encode())
          return
        body = read_file("400.html")
        header = ("Content-Length: " + str(len(body))
                  + CRLF + 'Connection: close' +
                  CRLF + 'Content-Type: text/html'
                  + CRLF)
        result = BAD_REQUEST + header + CRLF + body
        sock.send(result.encode())
        return

      # find the Accept header 406
      if len(lines) > 1:
        accept_items = ''
        for line in lines:
          if line.startswith("Accept:"):
            accept_items = line.strip("Accept:").strip().split(",")
            break
        if accept_items != '':
          file_type = os.path.splitext(resource)[1][1:]
          accept_error = True
          for x in accept_items:
            if "*/*" in x or file_type in x:
              accept_error = False
              break
          # Not Acceptable
          if accept_error:
            if method == 'HEAD': # send and return for HEAD
              result = NOT_ACCEPTABLE + CRLF + CRLF
              sock.send(result.encode())
              return
            body = ("resource requested are not acceptable" +
                      " according to accept headers\n")
            header = ("Content-Length: " + str(len(body)) + CRLF
                      + 'Connection: close' + CRLF)
            result = NOT_ACCEPTABLE + header+ CRLF + body
            sock.send(result.encode())
            return
              
      # create the local path from the resource
      local_file = '.' + resource
      
      # check if the file path exits
      if os.path.exists(local_file) and os.path.isfile(local_file):
        # check if others have permission to read 403
        if not is_others_readable(local_file):
          if method == 'HEAD': # send and return for HEAD
            result = FORBIDDEN + CRLF + CRLF
            sock.send(result.encode())
            return
          body = read_file("403.html")
          header = ("Content-Length: " + str(len(body))
                    + CRLF + 'Connection: close' +
                    CRLF + 'Content-Type: text/html'
                    + CRLF)
          result = FORBIDDEN + header + CRLF + body
          sock.send(result.encode())
          return
        # send the requested resource 200
        if method == 'HEAD': # send and return for HEAD
          result = OK + CRLF + CRLF
          sock.send(result.encode())
          return
        body = read_file(local_file)
        headers = ("Content-Length: " + str(len(body))
                   + CRLF + "Connection: close" + CRLF
                   + "Content-Type: text/html" + CRLF)
        result = OK + headers + CRLF + body
        sock.send(result.encode())
      # file not found 404
      else:
        if method == 'HEAD': # send and return for HEAD
          result = NOT_FOUND + CRLF + CRLF
          sock.send(result.encode())
          return
        body = read_file("404.html")
        header = ("Content-Length: " + str(len(body))
                  + CRLF + 'Connection: close' + CRLF
                  + 'Content-Type: text/html' + CRLF)
        result = NOT_FOUND + header+ CRLF + body
        sock.send(result.encode())

    elif method == "POST":
      # Get the last line
      last_line = lines[len(lines)-1]
      body_items = last_line.split('&')
      # accept the post if it is not form and sent 202
      if len(body_items) == 1:
        post_accept(sock)
        return
      body = ""
      for x in body_items:
        pair = x.split('=')
        a = pair[0].strip()
        # accept the post if it is not valid input
        if not a:
          post_accept(sock)
          return
        b = pair[1]
        if "%3A" in b:
          b = b.split("%3A")[0] + ":" + b.split("%3A")[1]
        body = (body + "<tr>" + "<td>" + a +"</td>"
                + "<td>" + b + "</td>" +"</tr>")
      body = "<table>" + body + "</table>"
      body = "<p>Following Form Data Submitted Successsfully:</p>" + body
      body = "<html>" + "<body>" + body + "</body>" + "</html>"
      header = ("Content-Length: " + str(len(body)) + CRLF
                + 'Connection: close' + CRLF +
                'Content-Type: text/html' + CRLF)
      result = OK + header+ CRLF + body
      sock.send(result.encode())

    # blank line
    elif method == '':
      print("doing nothing for blank line" + CRLF)

    # method not allow 405
    else:
      body = "Method is not allowed.\n"
      header = "Content-Length: " + str(len(body)) + CRLF
      result = METHOD_NOT_ALLOWED + header + CRLF + body
      sock.send(result.encode())      

# my helper function
def read_file(path):
    with open(path) as f:
       r = f.read()
       f.close()
       return r

def is_others_readable(path):
    st = os.stat(path)
    return bool(st.st_mode & stat.S_IROTH)

def post_accept(s):
    body = read_file("202.html")
    header = ("Content-Length: " + str(len(body)) + 
              CRLF + "Content-Type: text/html" + 
              CRLF + 'Connection: close' + CRLF)
    result = ACCEPTED + header+ CRLF + body
    s.send(result.encode())

# Connect to Client
def client_talk(client_sock, client_addr):
    print('talking to {}'.format(client_addr))
    data = client_sock.recv(BUFSIZE).decode('utf-8')
    while data:
      process_data(data, client_sock)
      data = client_sock.recv(BUFSIZE).decode('utf-8')

    # clean up
    client_sock.shutdown(1)
    client_sock.close()
    print('connection closed.')

class EchoServer:
  def __init__(self, host, port):
    print('listening on port {}'.format(port) + '\n')
    self.host = host
    self.port = port

    self.setup_socket()

    self.accept()

    self.sock.shutdown()
    self.sock.close()

  def setup_socket(self):
    self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    self.sock.bind((self.host, self.port))
    self.sock.listen(128)

  def accept(self):
    while True:
      (client, address) = self.sock.accept()
      th = Thread(target=client_talk, args=(client, address))
      th.start()

def parse_args():
  parser = ArgumentParser()
  parser.add_argument('--host', '-host', type=str, default='localhost',
               help='specify a host to operate on (default: localhost)')
  parser.add_argument('-p', '--port', '-port', type=int, default=9001,
               help='specify a port to operate on (default: 9001)')
  args = parser.parse_args()
  return (args.host, args.port)


if __name__ == '__main__':
  (host, port) = parse_args()
  EchoServer(host, port)

