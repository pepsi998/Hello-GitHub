import java.io.UnsupportedEncodingException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.NoSuchProviderException;

import javax.crypto.Cipher;
import javax.crypto.NoSuchPaddingException;

public class Test implements Runnable
{

	private static String iv = "20376e191ee42dbc0c170320e31fce69";
	private static String toDecrypt = "79NML1+Ysj0LD2CTKDhic7r4A2FeAAfPnKOCqho7AwkMv5OaiL/OaMZe76mBNQ4SgQWEPVSYlRAfkbt4pUwVSA==";
	private static String keySuff = "09dae6b4522515af257f0a6d1416fecb8c563f24a455fe1be51c03816d6f5f";
	private Decrypt dec = new Decrypt(iv, toDecrypt, keySuff);
	private int i;
	Test(int i)	{
		this.i = i;
	}
	public static void main(String[] args) 
			throws NoSuchAlgorithmException, NoSuchPaddingException, UnsupportedEncodingException, InvalidKeyException,
			InvalidAlgorithmParameterException, NoSuchProviderException
	{
	
		Test [] test = new Test[16];
		Thread [] thread = new Thread[16];
		for(int i=0;i<16;i++)	{
			test[i] = new Test(i);
			thread[i] = new Thread(test[i]);
			thread[i].start();
			
		}
		
	}
	
	public void search(int i,Decrypt dec) throws NoSuchAlgorithmException, NoSuchPaddingException	{
		
		dec.cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
		
	/*	for(int a = 0; a < 16; a++)	{
			for(int b = 0; b < 16; b++)	{
				for(int c = 0; c < 16; c++)	{
					for (int d = 0; d < 16; ++d)	{
						for (int e = 0; e < 16; ++e)	{
							for (int f = 0; f < 16; ++f)	{
								for (int g = 0; g < 16; ++g)	{*/
									for (int h = 0; h < 16; ++h)
									{
										String key = Integer.toHexString(i)/* + Integer.toHexString(a)
												+ Integer.toHexString(b) +Integer.toHexString(c)
												+ Integer.toHexString(d)
												+ Integer.toHexString(e) + Integer.toHexString(f)
												+ Integer.toHexString(g)*/ + Integer.toHexString(h) + keySuff;
										try
										{
											dec.decode(key);
										} catch (InvalidKeyException | NoSuchAlgorithmException | NoSuchPaddingException
												| InvalidAlgorithmParameterException e1)
										{
											e1.printStackTrace();
										}
								/*	}
								}
							
						}
					}
				}
			}
			}*/
		}
	}

	@Override
	public void run() {
		try {
			search(i,dec);
		} catch (NoSuchAlgorithmException | NoSuchPaddingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
}